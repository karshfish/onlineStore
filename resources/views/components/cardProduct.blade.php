@props(['product'])

<a href="{{ route('products.show', $product['id']) }}" 
   class="block product-card bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 cursor-pointer"
   data-id="{{ $product['id'] }}"
   data-name="{{ strtolower($product['title'] ?? $product['name']) }}"
   data-category="{{ strtolower($product['category'] ?? '') }}"
   data-price="{{ $product['price'] ?? 0 }}">
    
    <!-- Product Image -->
    <div class="relative overflow-hidden">
        <img 
            src="{{ $product['image'] ?? asset('storage/products/default.png') }}" 
            alt="{{ $product['title'] ?? $product['name'] }}"
            class="w-full h-48 object-cover hover:scale-105 transition-transform duration-500"
        >
        
        @if(($product['on_sale'] ?? false))
        <span class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
            SALE
        </span>
        @endif
    </div>

    <!-- Product Content -->
    <div class="p-6">
        <!-- Category -->
        @if($product['category'] ?? false)
        <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide mb-2">
            {{ $product['category'] }}
        </div>
        @endif

        <!-- Title -->
        <h3 class="font-bold text-gray-900 text-lg mb-3">
            {{ $product['title'] ?? $product['name'] }}
        </h3>

        <!-- Price & Button -->
        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-blue-600">${{ number_format($product['price'] ?? 0, 2) }}</span>
            <button 
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                onclick="event.stopPropagation()"
            >
                Add to Cart
            </button>
        </div>
    </div>
</a>
