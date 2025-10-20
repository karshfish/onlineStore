@extends('components.layout')

@section('title', 'Create New Product')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Create New Product</h1>
        <p class="text-gray-600">Add a new product to your store</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <span class="text-green-800 font-medium">{{ session('success') }}</span>
        </div>
        @if(session('product_data'))
        <div class="mt-2 text-green-700">
            Product data: {{ json_encode(session('product_data')) }}
        </div>
        @endif
    </div>
    @endif

    <!-- Product Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('products.store') }}" method="POST" class="p-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Product Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Title *
                        </label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title') }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            placeholder="Enter product title"
                        >
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                            Price *
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500">$</span>
                            </div>
                            <input 
                                type="number" 
                                id="price" 
                                name="price" 
                                value="{{ old('price') }}"
                                step="0.01"
                                min="0"
                                required
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                                placeholder="0.00"
                            >
                        </div>
                        @error('price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                            Category *
                        </label>
                        <select 
                            id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                        >
                            <option value="">Select a category</option>
                            <option value="electronics" {{ old('category') == 'electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="clothing" {{ old('category') == 'clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="home" {{ old('category') == 'home' ? 'selected' : '' }}>Home & Garden</option>
                            <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>Sports</option>
                            <option value="books" {{ old('category') == 'books' ? 'selected' : '' }}>Books</option>
                            <option value="beauty" {{ old('category') == 'beauty' ? 'selected' : '' }}>Beauty</option>
                            <option value="toys" {{ old('category') == 'toys' ? 'selected' : '' }}>Toys</option>
                            <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Image URL -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Image URL
                        </label>
                        <input 
                            type="url" 
                            id="image" 
                            name="image" 
                            value="{{ old('image') }}"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
                            placeholder="https://example.com/image.jpg"
                        >
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- On Sale Toggle -->
                    <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                        <div>
                            <label for="on_sale" class="text-sm font-medium text-gray-700">
                                On Sale
                            </label>
                            <p class="text-sm text-gray-500">Mark this product as on sale</p>
                        </div>
                        <div class="relative inline-block w-12 h-6">
                            <input 
                                type="checkbox" 
                                id="on_sale" 
                                name="on_sale" 
                                value="1" 
                                {{ old('on_sale') ? 'checked' : '' }}
                                class="sr-only"
                            >
                            <label 
                                for="on_sale" 
                                class="block w-12 h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ old('on_sale') ? 'bg-green-500' : '' }}"
                            >
                                <span class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-200 ease-in-out transform {{ old('on_sale') ? 'translate-x-6' : '' }}"></span>
                            </label>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Image Preview
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <img id="previewImage" src="" alt="Preview" class="mx-auto max-h-48 rounded-lg hidden">
                            <p id="noPreview" class="text-gray-500 text-sm">Image preview will appear here</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none"
                    placeholder="Enter product description"
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
                <a 
                    href="{{ route('products.index') }}" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors text-center font-medium"
                >
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium flex items-center justify-center"
                >
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('imagePreview');
    const previewImage = document.getElementById('previewImage');
    const noPreview = document.getElementById('noPreview');

    // Image preview functionality
    imageInput.addEventListener('input', function() {
        const imageUrl = this.value.trim();
        
        if (imageUrl) {
            imagePreview.classList.remove('hidden');
            previewImage.src = imageUrl;
            previewImage.classList.remove('hidden');
            noPreview.classList.add('hidden');
            
            // Handle image load errors
            previewImage.onerror = function() {
                previewImage.classList.add('hidden');
                noPreview.textContent = 'Failed to load image';
                noPreview.classList.remove('hidden');
            };
            
            previewImage.onload = function() {
                noPreview.classList.add('hidden');
            };
        } else {
            imagePreview.classList.add('hidden');
            previewImage.classList.add('hidden');
            noPreview.textContent = 'Image preview will appear here';
            noPreview.classList.remove('hidden');
        }
    });

    // Toggle switch styling
    const toggleSwitch = document.getElementById('on_sale');
    const toggleLabel = toggleSwitch.nextElementSibling;
    
    toggleSwitch.addEventListener('change', function() {
        if (this.checked) {
            toggleLabel.classList.add('bg-green-500');
            toggleLabel.classList.remove('bg-gray-300');
        } else {
            toggleLabel.classList.remove('bg-green-500');
            toggleLabel.classList.add('bg-gray-300');
        }
    });
});
</script>
@endsection