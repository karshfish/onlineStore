@extends('components.layout')

@section('title', $product['title'] ?? $product['name'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img 
                    src="{{ $product['image'] ?? '/images/placeholder-product.jpg' }}" 
                    alt="{{ $product['title'] ?? $product['name'] }}"
                    class="w-full h-96 object-cover"
                >
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product['title'] ?? $product['name'] }}</h1>
                <div class="text-2xl font-bold text-blue-600 mb-4">${{ number_format($product['price'] ?? 0, 2) }}</div>
                
                @if($product['category'] ?? false)
                <div class="text-sm text-blue-600 font-semibold uppercase mb-4">
                    {{ $product['category'] }}
                </div>
                @endif
                
                <p class="text-gray-600 mb-6">{{ $product['description'] ?? 'No description available.' }}</p>
                
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold text-lg transition-colors">
                    Add to Cart - ${{ number_format($product['price'] ?? 0, 2) }}
                </button>
            </div>
        </div>
    </div>
</div>
@endsection