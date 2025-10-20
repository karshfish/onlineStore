@extends('components.layout')

@section('title', 'Products')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Search Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Products</h1>
        
        <!-- Search Input -->
        <div class="max-w-md mx-auto relative">
            <input 
                type="text" 
                id="productSearch"
                placeholder="Search products..." 
                class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white shadow-sm text-lg"
            >
            <div class="absolute left-4 top-1/2 transform -translate-y-1/2 pointer-events-none">
                <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
        </div>
    </div>
<!-- Add this after the search header -->
<div class="text-center mb-8">
    <a 
        href="{{ route('products.create') }}" 
        class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium"
    >
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Add New Product
    </a>
</div>
    <!-- Filters Section -->
    <div class="mb-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row gap-6 items-start md:items-center justify-between">
            <!-- Category Filter -->
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select id="categoryFilter" class="w-full md:w-48 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Categories</option>
                    <option value="electronics">Electronics</option>
                    <option value="clothing">Clothing</option>
                    <option value="home">Home & Garden</option>
                    <option value="sports">Sports</option>
                    <option value="books">Books</option>
                    <option value="beauty">Beauty</option>
                </select>
            </div>

            <!-- Price Filter -->
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                <select id="priceFilter" class="w-full md:w-48 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Prices</option>
                    <option value="0-50">$0 - $50</option>
                    <option value="50-100">$50 - $100</option>
                    <option value="100-200">$100 - $200</option>
                    <option value="200-500">$200 - $500</option>
                    <option value="500-1000">$500 - $1000</option>
                    <option value="1000+">$1000+</option>
                </select>
            </div>

            <!-- Sort By -->
            <div class="w-full md:w-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select id="sortFilter" class="w-full md:w-48 border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="name">Name A-Z</option>
                    <option value="name-desc">Name Z-A</option>
                    <option value="price">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                </select>
            </div>

            <!-- Clear Filters -->
            <div class="w-full md:w-auto flex items-end">
                <button id="clearFilters" class="w-full md:w-auto bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div id="productsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($products as $product)
            <x-cardProduct 
                :product="$product"
                data-name="{{ strtolower($product['title'] ?? $product['name']) }}"
                data-category="{{ strtolower($product['category'] ?? '') }}"
                data-price="{{ $product['price'] ?? 0 }}"
            />
        @endforeach
    </div>

    <!-- No Results Message (Hidden by default) -->
    <div id="noResults" class="hidden text-center py-12">
        <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No products found</h3>
        <p class="text-gray-500">Try adjusting your search terms or filters</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('productSearch');
    const categoryFilter = document.getElementById('categoryFilter');
    const priceFilter = document.getElementById('priceFilter');
    const sortFilter = document.getElementById('sortFilter');
    const clearFilters = document.getElementById('clearFilters');
    const productCards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('noResults');

    // Make cards clickable
    productCards.forEach(card => {
        card.style.cursor = 'pointer';
        card.addEventListener('click', function(e) {
            // Don't navigate if clicking the button
            if (e.target.tagName === 'BUTTON' || e.target.closest('button')) {
                return;
            }
            const productId = this.getAttribute('data-id');
            if (productId) {
                window.location.href = `/products/${productId}`;
            }
        });
    });

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categoryFilter.value;
        const selectedPrice = priceFilter.value;
        const sortBy = sortFilter.value;

        let visibleCount = 0;
        const visibleProducts = [];

        productCards.forEach(card => {
            const productName = card.getAttribute('data-name');
            const productCategory = card.getAttribute('data-category');
            const productPrice = parseFloat(card.getAttribute('data-price'));
            const productId = card.getAttribute('data-id');

            // Search filter
            const matchesSearch = productName.includes(searchTerm) || 
                                 productCategory.includes(searchTerm) ||
                                 searchTerm === '';

            // Category filter
            const matchesCategory = selectedCategory === '' || 
                                   productCategory === selectedCategory;

            // Price filter
            let matchesPrice = true;
            if (selectedPrice !== '') {
                if (selectedPrice === '1000+') {
                    matchesPrice = productPrice >= 1000;
                } else {
                    const [min, max] = selectedPrice.split('-').map(Number);
                    matchesPrice = productPrice >= min && productPrice <= max;
                }
            }

            const isVisible = matchesSearch && matchesCategory && matchesPrice;

            if (isVisible) {
                card.style.display = 'block';
                visibleCount++;
                visibleProducts.push({
                    element: card,
                    name: productName,
                    price: productPrice,
                    id: productId
                });
            } else {
                card.style.display = 'none';
            }
        });

        // Sort products
        if (sortBy && visibleProducts.length > 0) {
            sortProducts(visibleProducts, sortBy);
        }

        // Show/hide no results message
        if (visibleCount === 0 && (searchTerm !== '' || selectedCategory !== '' || selectedPrice !== '')) {
            noResults.classList.remove('hidden');
        } else {
            noResults.classList.add('hidden');
        }
    }

    function sortProducts(products, sortBy) {
        products.sort((a, b) => {
            switch (sortBy) {
                case 'name':
                    return a.name.localeCompare(b.name);
                case 'name-desc':
                    return b.name.localeCompare(a.name);
                case 'price':
                    return a.price - b.price;
                case 'price-desc':
                    return b.price - a.price;
                default:
                    return 0;
            }
        });

        // Reorder DOM elements
        const productsGrid = document.getElementById('productsGrid');
        products.forEach(product => {
            productsGrid.appendChild(product.element);
        });
    }

    // Event listeners
    searchInput.addEventListener('input', filterProducts);
    categoryFilter.addEventListener('change', filterProducts);
    priceFilter.addEventListener('change', filterProducts);
    sortFilter.addEventListener('change', filterProducts);

    clearFilters.addEventListener('click', function() {
        searchInput.value = '';
        categoryFilter.value = '';
        priceFilter.value = '';
        sortFilter.value = 'name';
        filterProducts();
    });

    // Focus search input on page load
    searchInput.focus();
});
</script>
@endsection