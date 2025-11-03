@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <!-- Header Section -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Products</h1>
                    <p class="mt-2 text-gray-600">Discover amazing products from verified vendors</p>
                </div>
                
                <!-- View Toggle & Sort -->
                <div class="flex items-center space-x-4">
                    <div class="flex bg-white border-2 border-gray-200 rounded-xl overflow-hidden" role="group">
                        <button type="button" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 border-r border-gray-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                        </button>
                        <button type="button" class="px-4 py-2 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center justify-between px-6 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all duration-200">
                            <span class="mr-2">Sort by:</span>
                            <span class="text-blue-600">
                                @switch(request('sort'))
                                    @case('price_low')
                                        Price: Low to High
                                        @break
                                    @case('price_high')
                                        Price: High to Low
                                        @break
                                    @case('newest')
                                        Newest
                                        @break
                                    @case('rating')
                                        Best Rating
                                        @break
                                    @case('name')
                                        Name
                                        @break
                                    @default
                                        Featured
                                @endswitch
                            </span>
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-56 origin-top-right bg-white border-2 border-gray-200 rounded-xl shadow-xl">
                            <div class="py-2">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'featured']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'featured' || !request('sort') ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Featured</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'price_low' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Price: Low to High</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'price_high' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Price: High to Low</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'newest' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Newest</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'rating' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Best Rating</a>
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'name']) }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200 {{ request('sort') == 'name' ? 'bg-blue-50 text-blue-600 font-semibold' : '' }}">Name</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-4 lg:gap-8">
            <!-- Filters Sidebar -->
            <div class="hidden lg:block">
                <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 sticky top-6">
                    <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                        
                        <div class="space-y-6">
                            <!-- Categories Filter -->
                            @if($categories->isNotEmpty())
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                    Categories
                                </h3>
                                <div class="space-y-3">
                                    @foreach($categories->take(8) as $category)
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" 
                                               name="category[]" 
                                               value="{{ $category->id }}"
                                               {{ in_array($category->id, (array)request('category', [])) ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">{{ $category->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Price Range Filter -->
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Price Range
                                </h3>
                                <div class="space-y-3">
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" 
                                               name="price_range" 
                                               value="0-25"
                                               {{ request('price_range') == '0-25' ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">Under $25</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" 
                                               name="price_range" 
                                               value="25-50"
                                               {{ request('price_range') == '25-50' ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">$25 - $50</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" 
                                               name="price_range" 
                                               value="50-100"
                                               {{ request('price_range') == '50-100' ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">$50 - $100</span>
                                    </label>
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="radio" 
                                               name="price_range" 
                                               value="100-999999"
                                               {{ request('price_range') == '100-999999' ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">Over $100</span>
                                    </label>
                                    @if(request('price_range'))
                                    <button type="button" 
                                            onclick="document.querySelector('input[name=price_range]:checked').checked = false; document.getElementById('filter-form').submit()"
                                            class="text-sm text-blue-600 hover:text-blue-700 font-semibold">
                                        Clear price filter
                                    </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            @if($brands->isNotEmpty())
                            <div class="pt-6 border-t border-gray-200">
                                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                                    </svg>
                                    Brands
                                </h3>
                                <div class="space-y-3">
                                    @foreach($brands->take(8) as $brand)
                                    <label class="flex items-center cursor-pointer group">
                                        <input type="checkbox" 
                                               name="brand[]" 
                                               value="{{ $brand->id }}"
                                               {{ in_array($brand->id, (array)request('brand', [])) ? 'checked' : '' }}
                                               onchange="document.getElementById('filter-form').submit()"
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span class="ml-3 text-sm text-gray-700 group-hover:text-blue-600 transition-colors duration-200">{{ $brand->name }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Clear All Filters -->
                            @if(request()->hasAny(['category', 'brand', 'price_range', 'min_rating']))
                            <div class="pt-6 border-t border-gray-200">
                                <a href="{{ route('products.index') }}" 
                                   class="block w-full text-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    Clear All Filters
                                </a>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                <!-- Mobile Filter Button -->
                <div class="lg:hidden mb-6">
                    <button type="button" class="flex items-center justify-center w-full px-4 py-3 text-sm font-semibold text-gray-700 bg-white border-2 border-gray-200 rounded-xl hover:border-blue-300 hover:shadow-md transition-all duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"></path>
                        </svg>
                        Filters
                    </button>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($products as $product)
                    <div class="group relative bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-100 hover:-translate-y-2">
                        <!-- Product Image -->
                        <div class="relative aspect-square overflow-hidden bg-gradient-to-br from-blue-50 to-purple-50">
                            @php
                                $imageUrl = null;
                                if (isset($product->image) && $product->image) {
                                    $imageUrl = $product->image;
                                } elseif (isset($product->media) && $product->media->isNotEmpty()) {
                                    $imageUrl = $product->media->first()->url;
                                } else {
                                    // Use a reliable placeholder service
                                    $imageUrl = 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&size=400&background=667eea&color=ffffff&bold=true&format=svg';
                                }
                            @endphp
                            <img src="{{ $imageUrl }}" 
                                 alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-full h-full flex items-center justify-center\'><div class=\'text-center p-8\'><div class=\'w-24 h-24 mx-auto mb-4 bg-gradient-to-br from-blue-500 to-purple-600 rounded-2xl flex items-center justify-center\'><span class=\'text-4xl font-bold text-white\'>{{ strtoupper(substr($product->name, 0, 1)) }}</span></div><p class=\'text-sm font-semibold text-gray-600\'>{{ addslashes($product->name) }}</p></div></div>';">
                            
                            
                            <!-- Wishlist Button -->
                            <button class="absolute top-3 right-3 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-lg hover:bg-red-50 transition-colors duration-200 group/wishlist">
                                <svg class="w-5 h-5 text-gray-400 group-hover/wishlist:text-red-500 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </button>
                            
                            <!-- Badge -->
                            @if($product->created_at->diffInDays(now()) < 7)
                            <div class="absolute top-3 left-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                                NEW
                            </div>
                            @endif
                            
                            <!-- Quick View Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                <a href="{{ route('products.show', $product->id) }}" class="transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 bg-white text-gray-900 px-6 py-2 rounded-full font-semibold shadow-xl hover:shadow-2xl">
                                    Quick View
                                </a>
                            </div>
                        </div>
                        
                        <!-- Product Info -->
                        <div class="p-5">
                            @if($product->brands->isNotEmpty())
                            <p class="text-xs font-semibold text-blue-600 uppercase tracking-wide mb-2">{{ $product->brands->first()->name }}</p>
                            @endif
                            
                            <h3 class="text-base font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors min-h-[3rem]">
                                <a href="{{ route('products.show', $product->id) }}">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            
                            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ Str::limit($product->description, 60) }}</p>
                            
                            <!-- Rating -->
                            <div class="flex items-center mb-3">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="text-yellow-400 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-500">({{ $product->reviews_count ?? rand(10, 200) }})</span>
                            </div>
                            
                            <!-- Price & Add to Cart -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                        ${{ number_format($product->price, 2) }}
                                    </p>
                                </div>
                                <button class="add-to-cart-btn w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl flex items-center justify-center hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 group-hover:scale-110" 
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}"
                                        data-product-price="{{ $product->price }}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3">
                        <div class="bg-white rounded-2xl shadow-md p-12 text-center border border-gray-100">
                            <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">No products found</h3>
                            <p class="text-gray-600 mb-6">Try adjusting your filters or search criteria</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                Clear Filters
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="mt-8">
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        {{ $products->links() }}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart buttons on product listing
    document.querySelectorAll('.add-to-cart-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const originalHTML = this.innerHTML;
            
            // Show loading state
            this.disabled = true;
            this.innerHTML = '<svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            
            // Create form data
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            
            // Submit to cart
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count
                    updateCartCount(data.cart_count);
                    
                    // Show success feedback
                    this.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>';
                    this.classList.remove('from-blue-600', 'to-purple-600');
                    this.classList.add('from-green-500', 'to-green-600');
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                        this.classList.remove('from-green-500', 'to-green-600');
                        this.classList.add('from-blue-600', 'to-purple-600');
                        this.disabled = false;
                    }, 2000);
                    
                    // Show toast message
                    showToast(`${productName} added to cart!`, 'success');
                } else {
                    this.innerHTML = originalHTML;
                    this.disabled = false;
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.innerHTML = originalHTML;
                this.disabled = false;
                showToast('Failed to add product to cart', 'error');
            });
        });
    });
    
    function updateCartCount(count) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }
    
    function showToast(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-2xl transition-all duration-300 transform translate-x-0 ${
            type === 'success' 
                ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' 
                : 'bg-gradient-to-r from-red-500 to-red-600 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span class="font-semibold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endpush
@endsection
