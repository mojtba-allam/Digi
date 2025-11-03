@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Shop by Category</h1>
            <p class="mt-2 text-gray-600">Discover products organized by categories</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Featured Categories -->
        @if($featuredCategories->isNotEmpty())
        <div class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Featured Categories</h2>
                <div class="flex items-center text-blue-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                    <span class="font-semibold">Trending Now</span>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredCategories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="group relative overflow-hidden rounded-2xl bg-white shadow-md hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:-translate-y-2">
                    <div class="aspect-w-3 aspect-h-2 relative">
                        @php
                            $categoryImage = 'https://ui-avatars.com/api/?name=' . urlencode($category->name) . '&size=400&background=random&color=ffffff&bold=true&format=svg';
                        @endphp
                        <img src="{{ $categoryImage }}" 
                             alt="{{ $category->name }}" 
                             class="h-48 w-full object-cover group-hover:scale-110 transition-transform duration-500"
                             loading="lazy">
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-xl font-bold mb-1">{{ $category->name }}</h3>
                        <p class="text-sm text-blue-200 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                        </p>
                    </div>
                    <!-- Hover Arrow -->
                    <div class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-2 group-hover:translate-x-0 transition-all duration-300 shadow-lg">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- All Categories -->
        @if($categories->isNotEmpty())
        <div class="mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-8">All Categories</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->id) }}" class="group bg-white border-2 border-gray-200 rounded-2xl p-6 hover:shadow-xl hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl flex items-center justify-center group-hover:from-blue-500 group-hover:to-purple-600 transition-all duration-300 overflow-hidden shadow-md">
                                @php
                                    $categoryIcon = 'https://ui-avatars.com/api/?name=' . urlencode(substr($category->name, 0, 1)) . '&size=64&background=667eea&color=ffffff&bold=true&format=svg';
                                @endphp
                                <span class="text-2xl font-bold text-blue-600 group-hover:text-white transition-colors duration-300">
                                    {{ strtoupper(substr($category->name, 0, 1)) }}
                                </span>
                            </div>
                        </div>
                        <div class="ml-5 flex-1">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-1">
                                {{ $category->name }}
                            </h3>
                            <p class="text-sm text-gray-500 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                {{ $category->products_count }} {{ Str::plural('product', $category->products_count) }}
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-blue-600 transition-colors duration-300">
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-white transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Popular Brands -->
        @if($brands->isNotEmpty())
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-gray-900">Popular Brands</h2>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-700 font-semibold flex items-center transition-colors duration-200">
                    View All
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand[]' => $brand->id]) }}" class="group bg-white border-2 border-gray-200 rounded-2xl p-6 text-center hover:shadow-xl hover:border-blue-300 transition-all duration-300 hover:-translate-y-1">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl mx-auto mb-4 flex items-center justify-center group-hover:from-blue-500 group-hover:to-purple-600 transition-all duration-300 overflow-hidden shadow-md">
                        @php
                            $brandIcon = 'https://ui-avatars.com/api/?name=' . urlencode(substr($brand->name, 0, 1)) . '&size=64&background=e5e7eb&color=374151&bold=true&format=svg';
                        @endphp
                        <span class="text-2xl font-bold text-gray-600 group-hover:text-white transition-colors duration-300">
                            {{ strtoupper(substr($brand->name, 0, 1)) }}
                        </span>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 group-hover:text-blue-600 transition-colors duration-300 mb-1">{{ $brand->name }}</h3>
                    <p class="text-xs text-gray-500">{{ $brand->products_count }} {{ Str::plural('item', $brand->products_count) }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Empty State -->
        @if($categories->isEmpty() && $featuredCategories->isEmpty())
        <div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-gray-100">
            <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Categories Available</h3>
            <p class="text-gray-600 mb-8">Check back later for new categories</p>
            <a href="{{ route('home') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
        @endif
    </div>
</div>
@endsection
