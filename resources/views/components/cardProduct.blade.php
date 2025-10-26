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
        <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2">
            {{ $product['title'] ?? $product['name'] }}
        </h3>

        <!-- Price & Comments -->
        <div class="flex items-center justify-between mb-3">
            <span class="text-xl font-bold text-blue-600">
                ${{ number_format($product['price'] ?? 0, 2) }}
            </span>

            <!-- ✅ Comment count -->
            <div class="flex items-center text-sm text-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M7 8h10M7 12h4m-2 8a9 9 0 100-18 9 9 0 000 18zm0 0v-2.5a2.5 2.5 0 012.5-2.5h1A2.5 2.5 0 0115 17.5V20" />
                </svg>
                <span>{{ $product['comments_count'] ?? 0 }}</span>
            </div>
        </div>

        <!-- Button -->
        <button 
            class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg text-sm font-medium transition-colors"
            onclick="event.stopPropagation()"
        >
            Add to Cart
        </button>
    </div>
</a>
