@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 flex justify-center items-center px-4">
    <div class="w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-6 px-8 relative overflow-hidden">
            <div class="absolute -top-4 -right-4 w-20 h-20 rounded-full bg-white/10"></div>
            <div class="absolute -bottom-8 -left-8 w-28 h-28 rounded-full bg-white/10"></div>
            
            <div class="relative z-10 flex items-center">
                <a href="{{ route('categories.index') }}" class="mr-4 text-white/80 hover:text-white transition duration-200">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">Edit Category</h1>
                    <p class="text-blue-100 text-sm mt-1">Update your category information</p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">
                    Category Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-tag text-gray-400"></i>
                    </div>
                    <input 
                        type="text"
                        name="name"
                        value="{{ old('name', $category->name) }}"
                        required
                        placeholder="Enter category name"
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200 shadow-sm"
                    >
                </div>
                @error('name')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Description -->
            <div class="space-y-2">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <div class="relative">
                    <div class="absolute top-3 left-3 pointer-events-none">
                        <i class="fas fa-align-left text-gray-400"></i>
                    </div>
                    <textarea 
                        name="description" 
                        rows="4"
                        placeholder="Write a short description..."
                        class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition duration-200 shadow-sm resize-none"
                    >{{ old('description', $category->description) }}</textarea>
                </div>
                @error('description')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Current Image -->
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Current Image</label>
                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    @if ($category->image)
                        <div class="relative group">
                            <img 
                                src="{{ asset('storage/' . $category->image) }}" 
                                alt="{{ $category->name }}" 
                                class="h-24 w-24 object-cover rounded-lg border border-gray-300 shadow-sm"
                            >
                            <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                                <span class="text-white text-xs font-medium">Preview</span>
                            </div>
                        </div>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">Current image</p>
                            <p class="text-xs text-gray-500 mt-1">This image will be replaced if you upload a new one</p>
                        </div>
                    @else
                        <div class="flex items-center gap-3 text-gray-500">
                            <i class="fas fa-image text-2xl"></i>
                            <div>
                                <p class="font-medium">No image uploaded</p>
                                <p class="text-xs mt-1">Upload an image to represent this category</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Upload New Image -->
            <div class="space-y-3">
                <label class="block text-sm font-medium text-gray-700">Upload New Image</label>
                <div class="flex items-center justify-center w-full">
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition duration-200">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-2xl mb-2"></i>
                            <p class="text-sm text-gray-500">
                                <span class="font-semibold">Click to upload</span> or drag and drop
                            </p>
                            <p class="text-xs text-gray-400 mt-1">PNG, JPG, WEBP up to 2MB</p>
                        </div>
                        <input 
                            type="file" 
                            name="image"
                            accept="image/*"
                            class="hidden"
                        >
                    </label>
                </div>
                @error('image')
                    <p class="text-red-600 text-sm mt-1 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input 
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="sr-only peer"
                        {{ old('is_active', $category->is_active) ? 'checked' : '' }}
                    >
                    <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-gray-700 font-medium">Active Category</span>
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-end items-center pt-6 border-t border-gray-200">
                <a href="{{ route('categories.index') }}"
                   class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 transition duration-200 shadow-sm flex items-center justify-center gap-2">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit"
                        class="w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg shadow-md hover:from-blue-700 hover:to-indigo-800 transition duration-200 flex items-center justify-center gap-2">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // File upload preview
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[type="file"]');
        
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const uploadText = document.querySelector('.flex.flex-col.items-center.justify-center.pt-5.pb-6');
                uploadText.innerHTML = `
                    <i class="fas fa-check text-green-500 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-600 font-medium">${fileName}</p>
                    <p class="text-xs text-gray-400 mt-1">Click to change</p>
                `;
            }
        });
    });
</script>
@endsection