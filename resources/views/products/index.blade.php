@extends('layouts.app')



@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header with Search and Create Button -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
            <!-- Title and Create Button -->
            <div class="flex items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-900">Our Products</h1>
                <!-- Create New Product Button -->
<a href="{{ route('products.create') }}" 
   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
    </svg>
    New Product
</a>
            </div>

            <!-- Search Bar -->
            <div class="relative flex-1 max-w-lg">
                <form action="{{ route('products.index') }}" method="GET" class="flex gap-2">
                    <input 
                        type="text" 
                        name="search"
                        value="{{ $filters['search'] ?? '' }}"
                        placeholder="Search products..." 
                        class="flex-1 pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white text-lg"
                    >
                    <div class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                        <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Search
                    </button>
                </form>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <form action="{{ route('products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Hidden search field to preserve search -->
                <input type="hidden" name="search" value="{{ $filters['search'] ?? '' }}">

                <!-- Category Filter -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ ($filters['category'] ?? '') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Min Price</label>
                    <input type="number" name="min_price" value="{{ $filters['min_price'] ?? '' }}" 
                           placeholder="0.00" step="0.01" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Max Price</label>
                    <input type="number" name="max_price" value="{{ $filters['max_price'] ?? '' }}" 
                           placeholder="1000.00" step="0.01" min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Stock & Sort -->
                <div class="flex flex-col gap-2">
                    <div class="flex items-center">
                        <input type="checkbox" id="in_stock" name="in_stock" value="1" 
                               {{ ($filters['in_stock'] ?? '') ? 'checked' : '' }}
                               class="mr-2 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <label for="in_stock" class="text-sm text-gray-700">In Stock Only</label>
                    </div>
                    
                    <select name="sort_by" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="name" {{ ($filters['sort_by'] ?? 'name') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                        <option value="price" {{ ($filters['sort_by'] ?? '') == 'price' ? 'selected' : '' }}>Sort by Price</option>
                        <option value="created_at" {{ ($filters['sort_by'] ?? '') == 'created_at' ? 'selected' : '' }}>Sort by Date</option>
                    </select>

                    <select name="sort_order" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                        <option value="asc" {{ ($filters['sort_order'] ?? 'asc') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ ($filters['sort_order'] ?? '') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                </div>

                <!-- Filter Actions -->
                <div class="md:col-span-4 flex gap-2 justify-end pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                        Apply Filters
                    </button>
                    <a href="{{ route('products.index') }}" class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        Clear All
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            @foreach($products as $product)
                <x-cardProduct :product="$product" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <!-- No Results -->
        <div class="text-center py-12 bg-white rounded-lg border border-gray-200">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
            <p class="text-gray-500 mb-4">Try adjusting your search terms or filters</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                Clear Filters
            </a>
        </div>
    @endif
</div>
@endsection