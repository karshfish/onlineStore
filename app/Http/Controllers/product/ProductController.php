<?php

namespace App\Http\Controllers\product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDOException;

class ProductController extends Controller
{

    public function __construct() {}



    public function index(Request $request)
    {
        // Get search query and filters from request
        $search = $request->query('search');
        $category = $request->query('category');
        $minPrice = $request->query('min_price');
        $maxPrice = $request->query('max_price');
        $sortBy = $request->query('sort_by', 'name');
        $sortOrder = $request->query('sort_order', 'asc');
        $inStock = $request->query('in_stock');


        $query = Product::query();

        // Apply search filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Apply category filter
        if ($category) {
            $query->where('category', $category);
        }

        // Apply price range filter
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Apply stock filter
        if ($inStock !== null) {
            $query->where('in_stock', (bool)$inStock);
        }

        // Apply sorting
        $allowedSortColumns = ['name', 'price', 'created_at', 'stock_quantity'];
        $sortBy = in_array($sortBy, $allowedSortColumns) ? $sortBy : 'name';
        $sortOrder = in_array($sortOrder, ['asc', 'desc']) ? $sortOrder : 'asc';

        $query->orderBy($sortBy, $sortOrder);

        // Get paginated results (20 products per page)
        $products = $query->paginate(20)->withQueryString();
        //add comments count to each products
        $products = $query->withCount('comments')->paginate(20)->withQueryString();
        // Get all categories for filter dropdown
        $categories = Product::distinct()->pluck('category')->sort();

        return view('products.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $category,
                'min_price' => $minPrice,
                'max_price' => $maxPrice,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
                'in_stock' => $inStock,
            ],
            'title' => 'Products List'
        ]);
    }




    public function createView()
    {
        return view('products.create');
    }


    public function store(Request $request) // store new record
    {


        $validData = $request->validate(
            [
                'name' => 'required|string|min:3',
                'description' => 'required|string|min:10',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string|in:Electronics,Clothing,Books,Home & Garden,Sports & Outdoors,Beauty & Personal Care,Toys & Games,Automotive,Health & Household,Jewelry',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:max_width=2000,max_height=2000', // 2MB max
                'brand' => 'nullable|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'in_stock' => 'sometimes|boolean',
                'is_active' => 'sometimes|boolean',

            ],
            [
                'image.required' => 'The product image is required.',
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                'image.max' => 'The image may not be greater than 2MB.',
                'name.min' => 'The product name must be at least 3 characters.',
                'description.min' => 'The description must be at least 10 characters.',
            ]
        );

        // Handle image
        if ($request->hasFile('image')) {
            $image = $request->file('image');


            $sanitizedName = Str::slug($request->name); // Convert "iPhone 15" to "iphone-15"
            $imageName = 'product_' . $sanitizedName . '_' . time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $image->storeAs('products', $imageName, 'public'); // Store the image in storage/app/public/products
            $imageURL = Storage::url($imagePath);
            $validData['image'] = $imageURL; // Save image url


        }

        // Handle boolean fields - FIXED the double $$ issue
        $validData['in_stock'] = $request->has('in_stock');
        $validData['is_active'] = $request->has('is_active');

        try {
            $product = Product::create($validData);
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // If database update fails, delete the uploaded image
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->with('error', 'Failed to update product: ' . $e->getMessage())
                ->withInput();
        }
    }



    public function edit($id) //show edit form
    {
        $oldProduct = Product::findOrFail($id);
        // dd($oldProduct);
        return view('products.edit', ['oldProduct' => $oldProduct, 'title' => 'Edit ' . $oldProduct['name']]);
    }



    public function update(Request $request) //update the product
    {
        $product = Product::findOrFail($request->id);

        $validData = $request->validate(
            [
                'name' => 'required|string|min:3',
                'description' => 'required|string|min:10',
                'price' => 'required|numeric|min:0',
                'category' => 'required|string|in:Electronics,Clothing,Books,Home & Garden,Sports & Outdoors,Beauty & Personal Care,Toys & Games,Automotive,Health & Household,Jewelry',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048|dimensions:max_width=7000,max_height=7000', // 2MB max
                'brand' => 'nullable|string|max:255',
                'stock_quantity' => 'required|integer|min:0',
                'in_stock' => 'sometimes|boolean',
                'is_active' => 'sometimes|boolean',

            ],
            [
                'image.required' => 'The product image is required.',
                'image.image' => 'The file must be an image.',
                'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, webp.',
                'image.max' => 'The image may not be greater than 2MB.',
                'name.min' => 'The product name must be at least 3 characters.',
                'description.min' => 'The description must be at least 10 characters.',
            ]
        );

        // Handle image
        if ($request->hasFile('image')) {
            $image = $request->file('image');


            $sanitizedName = Str::slug($request->name); // Convert "iPhone 15" to "iphone-15"
            $imageName = 'product_' . $sanitizedName . '_' . time() . '.' . $image->getClientOriginalExtension();

            $imagePath = $image->storeAs('products', $imageName, 'public'); // Store the image in storage/app/public/products
            $imageURL = Storage::url($imagePath);
            $validData['image'] = $imageURL; // Save image url

            // Delete old image if it exists and is in our storage
            $this->deleteOldImage($product->image);
        }

        // Handle boolean fields - FIXED the double $$ issue
        $validData['in_stock'] = $request->has('in_stock');
        $validData['is_active'] = $request->has('is_active');

        try {
            $product->update($validData);
            return redirect()->route('products.show', $product->id)
                ->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // If database update fails, delete the uploaded image
            if (isset($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }

            return redirect()->back()
                ->with('error', 'Failed to update product: ' . $e->getMessage())
                ->withInput();
        }
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


    public function destroy() //delete product
    {}

    public function show(Product $product)
    {
        $product->load('comments');

        $title = $product->title ?? $product->name;

        return view('products.show', compact('product', 'title'));
    }
}
