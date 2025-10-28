@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success/Error Messages -->
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

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            <span class="text-red-800 font-medium">{{ session('error') }}</span>
        </div>
    </div>
    @endif

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Edit Product</h1>
        <p class="text-gray-600 mt-2">Update product information</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('products.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
            @csrf
            @method('PUT')

            <!-- Hidden field for product ID -->
            <input type="hidden" name="id" value="{{ $oldProduct['id'] }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Product Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Name *
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name', $oldProduct['name']) }}"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('name') border-red-500 @enderror"
                            placeholder="Enter product name"
                        >
                        @error('name')
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
                                value="{{ old('price', $oldProduct['price']) }}"
                                step="0.01"
                                min="0"
                                required
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('price') border-red-500 @enderror"
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
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('category') border-red-500 @enderror"
                        >
                            <option value="">Select a category</option>
                            @foreach(['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports & Outdoors', 'Beauty & Personal Care', 'Toys & Games', 'Automotive', 'Health & Household', 'Jewelry'] as $category)
                                <option value="{{ $category }}" 
                                    {{ old('category', $oldProduct['category']) == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Quantity -->
                    <div>
                        <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                            Stock Quantity *
                        </label>
                        <input 
                            type="number" 
                            id="stock_quantity" 
                            name="stock_quantity" 
                            value="{{ old('stock_quantity', $oldProduct['stock_quantity']) }}"
                            min="0"
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors @error('stock_quantity') border-red-500 @enderror"
                            placeholder="Enter stock quantity"
                        >
                        @error('stock_quantity')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Image File Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Product Image *
                        </label>
                        
                        <!-- Current Image Preview -->
                        @if($oldProduct['image'])
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ $oldProduct['image'] }}" 
                                 alt="Current product image" 
                                 class="h-32 w-32 object-cover rounded-lg border border-gray-300">
                        </div>
                        @endif

                        <!-- File Upload -->
                        <div class="flex items-center justify-center w-full">
                            <label for="image" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors @error('image') border-red-500 @enderror">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Click to upload</span> or drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG, WEBP (MAX. 5MB)</p>
                                </div>
                                <input 
                                    id="image" 
                                    name="image" 
                                    type="file" 
                                    class="hidden"
                                    accept="image/*"
                                />
                            </label>
                        </div>
                        
                        <!-- File name display -->
                        <div id="fileName" class="mt-2 text-sm text-gray-600 hidden"></div>
                        
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Toggles -->
                    <div class="space-y-4">
                        <!-- In Stock Toggle -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div>
                                <label for="in_stock" class="text-sm font-medium text-gray-700">
                                    In Stock
                                </label>
                                <p class="text-sm text-gray-500">Product availability</p>
                            </div>
                            <div class="relative inline-block w-12 h-6">
                                <input 
                                    type="checkbox" 
                                    id="in_stock" 
                                    name="in_stock" 
                                    value="1" 
                                    {{ old('in_stock', $oldProduct['in_stock']) ? 'checked' : '' }}
                                    class="sr-only"
                                >
                                <label 
                                    for="in_stock" 
                                    class="block w-12 h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ old('in_stock', $oldProduct['in_stock']) ? 'bg-green-500' : '' }}"
                                >
                                    <span class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-200 ease-in-out transform {{ old('in_stock', $oldProduct['in_stock']) ? 'translate-x-6' : '' }}"></span>
                                </label>
                            </div>
                        </div>

                        <!-- Active Status Toggle -->
                        <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                            <div>
                                <label for="is_active" class="text-sm font-medium text-gray-700">
                                    Active Product
                                </label>
                                <p class="text-sm text-gray-500">Show product on website</p>
                            </div>
                            <div class="relative inline-block w-12 h-6">
                                <input 
                                    type="checkbox" 
                                    id="is_active" 
                                    name="is_active" 
                                    value="1" 
                                    {{ old('is_active', $oldProduct['is_active'] ?? true) ? 'checked' : '' }}
                                    class="sr-only"
                                >
                                <label 
                                    for="is_active" 
                                    class="block w-12 h-6 rounded-full bg-gray-300 cursor-pointer transition-colors duration-200 ease-in-out {{ old('is_active', $oldProduct['is_active'] ?? true) ? 'bg-blue-500' : '' }}"
                                >
                                    <span class="absolute top-0.5 left-0.5 bg-white w-5 h-5 rounded-full transition-transform duration-200 ease-in-out transform {{ old('is_active', $oldProduct['is_active'] ?? true) ? 'translate-x-6' : '' }}"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- New Image Preview -->
                    <div id="newImagePreview" class="hidden">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            New Image Preview
                        </label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                            <img 
                                id="previewNewImage" 
                                src="" 
                                alt="New image preview" 
                                class="mx-auto max-h-48 rounded-lg hidden"
                            >
                            <p id="noNewPreview" class="text-gray-500 text-sm">
                                New image preview will appear here
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mt-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description *
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors resize-none @error('description') border-red-500 @enderror"
                    placeholder="Enter product description"
                >{{ old('description', $oldProduct['description']) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end border-t pt-6">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('image');
    const fileNameDisplay = document.getElementById('fileName');
    const fileLabel = fileInput.closest('label');
    const newImagePreview = document.getElementById('newImagePreview');
    const previewNewImage = document.getElementById('previewNewImage');
    const noNewPreview = document.getElementById('noNewPreview');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Show file name
            fileNameDisplay.textContent = 'Selected file: ' + file.name;
            fileNameDisplay.classList.remove('hidden');
            
            // Change border color to indicate selection
            fileLabel.classList.add('border-green-500', 'bg-green-50');
            fileLabel.classList.remove('border-gray-300', 'bg-gray-50');
            
            // Show new image preview section
            newImagePreview.classList.remove('hidden');
            
            // Create image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                previewNewImage.src = e.target.result;
                previewNewImage.classList.remove('hidden');
                noNewPreview.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            fileNameDisplay.classList.add('hidden');
            fileLabel.classList.remove('border-green-500', 'bg-green-50');
            fileLabel.classList.add('border-gray-300', 'bg-gray-50');
            newImagePreview.classList.add('hidden');
            previewNewImage.classList.add('hidden');
            noNewPreview.classList.remove('hidden');
        }
    });

    // Drag and drop functionality
    fileLabel.addEventListener('dragover', function(e) {
        e.preventDefault();
        fileLabel.classList.add('border-blue-500', 'bg-blue-50');
    });

    fileLabel.addEventListener('dragleave', function(e) {
        e.preventDefault();
        if (!fileLabel.contains(e.relatedTarget)) {
            fileLabel.classList.remove('border-blue-500', 'bg-blue-50');
        }
    });

    fileLabel.addEventListener('drop', function(e) {
        e.preventDefault();
        fileLabel.classList.remove('border-blue-500', 'bg-blue-50');
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
    });

    // Toggle switch styling
    function setupToggle(toggleId) {
        const toggleSwitch = document.getElementById(toggleId);
        const toggleLabel = toggleSwitch.nextElementSibling;
        
        toggleSwitch.addEventListener('change', function() {
            if (this.checked) {
                if (toggleId === 'in_stock') {
                    toggleLabel.classList.add('bg-green-500');
                } else {
                    toggleLabel.classList.add('bg-blue-500');
                }
                toggleLabel.classList.remove('bg-gray-300');
            } else {
                toggleLabel.classList.remove('bg-green-500', 'bg-blue-500');
                toggleLabel.classList.add('bg-gray-300');
            }
        });
    }

    setupToggle('in_stock');
    setupToggle('is_active');
});
</script>
@endsection