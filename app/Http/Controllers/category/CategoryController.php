<?php

namespace App\Http\Controllers\category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Product;

class CategoryController extends Controller
{
    public function __construct()
    {
        // Apply middleware to only specific methods
        $this->middleware('auth')->only('create', 'store', 'update', 'edit');
        $this->middleware('product.limit')->only(['create', 'store']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Show product creation form

        $categories = Category::pluck('name', 'id'); // get all distinct categories


        return view('categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {

        $validated = $request->validated();

        //  image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Sanitize the name
            $sanitizedName = Str::slug($validated['name']);

            // Generate unique image name
            $imageName = 'category_' . $sanitizedName . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Store in storage/app/public/categories
            $path = $image->storeAs('categories', $imageName, 'public');

            // Save the public URL
            $validated['image'] = Storage::url($path);
        }

        $validated['is_active'] = $request->has('is_active');


        Category::create($validated);


        return redirect()->route('categories.index')->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Fetch only products that belong to this category
        $products = Product::where('category_id', $category->id)
            ->paginate(20)
            ->withQueryString();

        // Get categories list for sidebar/filter dropdown
        $categories = Product::distinct()->pluck('category')->sort();

        // Reuse the same view
        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => null,
                'category' => $category->name,
                'min_price' => null,
                'max_price' => null,
                'sort_by' => 'name',
                'sort_order' => 'asc',
                'in_stock' => null,
            ],
            'title' => "Products in {$category->name}"
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {

        $validated = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $sanitizedName = Str::slug($request->name);
            $imageName = 'category_' . $sanitizedName . '_' . time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $image->storeAs('categories', $imageName, 'public');
            $validated['image'] = Storage::url($imagePath);

            // Delete old image
            $this->deleteOldImage($category->image);
        }

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully!');
    }

    private function deleteOldImage($imageUrl)
    {
        try {
            // Extract filename from URL
            $filename = basename($imageUrl);

            // Check if the image is in our storage (not an external URL)
            if (str_contains($imageUrl, '/storage/products/')) {
                Storage::disk('public')->delete('products/' . $filename);
            }
        } catch (\Exception $e) {
            // Log error but don't stop the process
            Log::error('Failed to delete old image: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
