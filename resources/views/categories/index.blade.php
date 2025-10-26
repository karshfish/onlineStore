@extends('components.layout')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-blue-50 via-white to-blue-100 py-16">
    <div class="max-w-7xl mx-auto px-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-12">
            <div>
                <h1 class="text-4xl font-extrabold text-blue-800 mb-2">Shop by Category</h1>
                <p class="text-blue-600 text-sm">Browse top categories.</p>
            </div>
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-full shadow-md hover:bg-blue-700 hover:shadow-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
            </a>
        </div>

        <!-- Category Cards -->
        @if ($categories->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach ($categories as $category)
                    <div class="group relative bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <a href="{{ route('categories.show', $category) }}" class="block relative">
                            <img 
                                src="{{ $category->image ? asset($category->image) : asset('storage/categories/default.png') }}" 
                                alt="{{ $category->name }}"
                                class="h-56 w-full object-cover transition-transform duration-500 group-hover:scale-105"
                            >

                            <!-- Gradient overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

                            <!-- Category name overlay -->
                            <div class="absolute bottom-3 left-4">
                                <h2 class="text-lg font-bold text-white drop-shadow-sm">{{ $category->name }}</h2>
                            </div>
                        </a>

                        <div class="p-4 bg-white">
                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                {{ $category->description ?? 'Discover products in this category.' }}
                            </p>
                                 <!-- Product Count -->
        <div class="mt-3 flex items-center justify-between text-sm text-gray-600">
            <span class="bg-blue-50 text-blue-700 px-3 py-1 rounded-lg shadow-sm font-medium">
                {{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}
            </span>
        </div>
                            <div class="flex justify-between items-center">
                                <a href="{{ route('categories.show', $category) }}"
                                   class="text-sm font-medium text-blue-600 hover:text-blue-800 transition">
                                   View Details →
                                </a>
                                <a href="{{ route('categories.edit', $category) }}"
                                   class="text-sm font-medium text-gray-500 hover:text-blue-600 transition">
                                   Edit
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-lg mt-10">No categories yet — start by adding one!</p>
        @endif
    </div>
</div>
@endsection
