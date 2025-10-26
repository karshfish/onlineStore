@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="md:flex">
            <!-- Product Image -->
            <div class="md:w-1/2">
                <img 
                    src="{{ $product->image ?? '/images/placeholder-product.jpg' }}" 
                    alt="{{ $product->name }}"
                    class="w-full h-96 object-cover"
                >
            </div>
            
            <!-- Product Details -->
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                <div class="text-2xl font-bold text-blue-600 mb-4">${{ number_format($product->price, 2) }}</div>
                
                <!-- Category -->
                <div class="text-sm text-blue-600 font-semibold uppercase mb-4">
                    {{ $product->category }}
                </div>

                <!-- Stock Status -->
                <div class="mb-4">
                    @if($product->in_stock && $product->stock_quantity > 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            In Stock ({{ $product->stock_quantity }} available)
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Out of Stock
                        </span>
                    @endif
                </div>
                
                <!-- Description -->
                <p class="text-gray-600 mb-6">{{ $product->description }}</p>

                <!-- Additional Details -->
                <div class="grid grid-cols-2 gap-4 mb-6 text-sm text-gray-600">
                    <div>
                        <span class="font-semibold">Status:</span>
                        @if($product->is_active)
                            <span class="text-green-600">Active</span>
                        @else
                            <span class="text-red-600">Inactive</span>
                        @endif
                    </div>
                    <div>
                        <span class="font-semibold">Created:</span>
                        {{ $product?->created_at ? $product->created_at->format('M d, Y') : 'N/A' }}

                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="flex gap-4">
                    <button class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-6 rounded-lg font-semibold text-lg transition-colors flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Add to Cart - ${{ number_format($product->price, 2) }}
                    </button>
                    
                    <a href="{{ route('products.edit', $product->id) }}" 
                       class="flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Edit
                    </a>
                </div>

                <!-- Back to Products -->
                <div class="mt-6 pt-6 border-t border-gray-200">
                    <a href="{{ route('products.index') }}" 
                       class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Products
                    </a>
                </div>
            </div>
            <!-- Comments Section -->
<div class="mt-10 bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Comments ({{ $product->comments->count() }})
    </h2>

    {{-- Success & Error Messages --}}
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 text-green-700 border border-green-200 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-50 text-red-700 border border-red-200 rounded">
            <ul>
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- List Comments --}}
    @forelse($product->comments as $comment)
        <div class="border-b border-gray-200 pb-3 mb-3">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-800">{{ $comment->author_name }}</p>
                    <p class="text-sm text-gray-500">{{ $comment->author_email }}</p>
                </div>
                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">
                        Delete
                    </button>
                </form>
            </div>
            <p class="mt-2 text-gray-700">{{ $comment->content }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
        </div>
    @empty
        <p class="text-gray-500 italic">No comments yet. Be the first to comment!</p>
    @endforelse

    {{-- Comment Form --}}
    <form action="{{ route('comments.store', $product->id) }}" method="POST" class="mt-6 space-y-4">
        @csrf
        <input type="hidden" name="commentable_type" value="{{ get_class($product) }}">

        <input type="hidden" name="commentable_id" value="{{ $product->id }}">

        <div>
            <label for="author_name" class="block text-sm font-semibold text-gray-700 mb-1">Your Name</label>
            <input type="text" id="author_name" name="author_name" value="{{ old('author_name') }}" 
                   class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="author_email" class="block text-sm font-semibold text-gray-700 mb-1">Your Email</label>
            <input type="email" id="author_email" name="author_email" value="{{ old('author_email') }}" 
                   class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div>
            <label for="content" class="block text-sm font-semibold text-gray-700 mb-1">Your Comment</label>
            <textarea id="content" name="content" rows="3" 
                      class="w-full border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">{{ old('content') }}</textarea>
        </div>

        <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-medium transition-colors">
            Post Comment
        </button>
    </form>
</div>

        </div>
    </div>
</div>
@endsection