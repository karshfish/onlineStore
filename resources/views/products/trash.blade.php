@extends('layouts.app')

@section('title', 'Deleted Products')

@section('content')
<div class="max-w-6xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">🗑️ Deleted Products</h1>

    @if (session('status'))
        <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 border border-green-300">
            {!! session('status') !!}
        </div>
    @endif

    @if($deletedProducts->isEmpty())
        <p class="text-gray-500">No deleted products found.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($deletedProducts as $product)
                <div class="bg-white shadow rounded-2xl p-6 border hover:shadow-md transition">
                    <img 
                        src="{{ $product->image ? asset('storage/' . $product->image) : asset('storage/products/default.png') }}" 
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover rounded-xl mb-4"
                    >

                    <h2 class="text-lg font-semibold text-gray-800">{{ $product->name }}</h2>
                    <p class="text-gray-500 mb-4">${{ number_format($product->price, 2) }}</p>

                    <form action="{{ route('products.restore', $product->id) }}" method="POST">
                        @csrf
                        <button 
                            type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Restore
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
