@props(['product'])

<div 
    class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden border border-gray-100 cursor-pointer flex flex-col"
    onclick="window.location='{{ route('products.show', $product['id']) }}'">

    <!-- 🖼️ Product Image -->
    <div class="relative overflow-hidden">
        <img 
            src="{{ $product['image'] ?? asset('storage/products/default.png') }}" 
            alt="{{ $product['title'] ?? $product['name'] }}"
            class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-500"
        >

        @if(!empty($product['on_sale']))
            <span class="absolute top-3 left-3 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-md">
                SALE
            </span>
        @endif
    </div>

    <!-- 🧾 Product Content -->
    <div class="p-6 flex flex-col justify-between flex-grow">
        @if(!empty($product['category']))
            <div class="text-xs text-blue-600 font-semibold uppercase tracking-wide mb-2">
                {{ $product['category'] }}
            </div>
        @endif

        <h3 class="font-bold text-gray-900 text-lg mb-3 line-clamp-2 leading-snug">
            {{ $product['title'] ?? $product['name'] }}
        </h3>

        <div class="flex items-center justify-between mt-auto mb-4">
            <span class="text-xl font-bold text-blue-600">
                ${{ number_format($product['price'] ?? 0, 2) }}
            </span>

            <div class="flex items-center text-sm text-gray-500">
                <i class="fa-regular fa-comments mr-1 text-gray-400"></i>
                <span>{{ $product['comments_count'] ?? 0 }}</span>
            </div>
        </div>

        <!-- 🗑️ Delete Button (only for admin/manager) -->
        @auth
            @if(auth()->user()->role === 'admin' )
                <form action="{{ route('products.destroy', $product->id) }}" 
                      method="POST" 
                      class="mt-auto"
                      onsubmit="event.stopPropagation(); return confirm('Are you sure you want to delete this product?');"
                      onclick="event.stopPropagation();">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 rounded-lg shadow-md transition-all duration-200">
                        <i class="fa-solid fa-trash"></i>
                        Delete
                    </button>
                </form>
            @endif
        @endauth
    </div>
</div>
