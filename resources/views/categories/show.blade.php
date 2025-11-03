@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="bg-white">
    <!-- Category Header -->
    <div class="border-b border-gray-200 pb-6 pt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-4" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">Home</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <a href="{{ route('categories.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Categories</a>
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                            <span class="ml-2 text-sm font-medium text-gray-900">{{ $category->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $category->name }}</h1>
                    <p class="mt-2 text-sm text-gray-500">{{ $products->total() }} products</p>
                </div>
                
                <!-- Sort Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Sort by: 
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
                            @default
                                Newest
                        @endswitch
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    
                    <div x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-56 origin-top-right bg-white border border-gray-300 rounded-md shadow-lg">
                        <div class="py-1">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'newest' || !request('sort') ? 'bg-blue-50 text-blue-700' : '' }}">Newest</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'price_low' ? 'bg-blue-50 text-blue-700' : '' }}">Price: Low to High</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'price_high' ? 'bg-blue-50 text-blue-700' : '' }}">Price: High to Low</a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'rating']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ request('sort') == 'rating' ? 'bg-blue-50 text-blue-700' : '' }}">Best Rating</a>
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
                <form method="GET" action="{{ route('categories.show', $category->id) }}" id="filter-form">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    
                    <div class="space-y-6">
                        <!-- Brands Filter -->
                        @if($availableBrands->isNotEmpty())
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Brands</h3>
                            <div class="space-y-3">
                                @foreach($availableBrands->take(8) as $brand)
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" 
                                           name="brand" 
                                           value="{{ $brand->id }}"
                                           {{ request('brand') == $brand->id ? 'checked' : '' }}
                                           onchange="document.getElementById('filter-form').submit()"
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ $brand->name }}</span>
                                </label>
                                @endforeach
                                @if(request('brand'))
                                <button type="button" onclick="document.querySelector('input[name=brand]:checked').checked = false; document.getElementById('filter-form').submit();" class="text-sm text-blue-600 hover:text-blue-800">Clear</button>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Price Range Filter -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Price Range</h3>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Min Price</label>
                                    <input type="number" 
                                           name="min_price" 
                                           value="{{ request('min_price') }}"
                                           placeholder="$0"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Max Price</label>
                                    <input type="number" 
                                           name="max_price" 
                                           value="{{ request('max_price') }}"
                                           placeholder="$1000"
                                           min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your filters</p>
                </div>
                @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                    <div class="group relative bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                        <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gradient-to-br from-blue-50 to-purple-50">
                            <a href="{{ route('products.show', $product->id) }}">
                                @php
                                    $productImageUrl = $product->image ?? ($product->media->isNotEmpty() ? $product->media->first()->url : 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&size=300&background=667eea&color=ffffff&bold=true&format=svg');
                                @endphp
                                <img src="{{ $productImageUrl }}" 
                                     alt="{{ $product->name }}" 
                                     class="h-48 w-full object-cover object-center group-hover:opacity-75 transition-opacity duration-200"
                                     loading="lazy">
                            </a>
                        </div>
                        <div class="p-4">
                            <h3 class="text-sm font-medium text-gray-900">
                                <a href="{{ route('products.show', $product->id) }}" class="hover:text-blue-600">
                                    {{ $product->name }}
                                </a>
                            </h3>
                            @if($product->brands->isNotEmpty())
                            <p class="mt-1 text-xs text-gray-500">{{ $product->brands->first()->name }}</p>
                            @endif
                            <div class="mt-2 flex items-center">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="text-yellow-400 h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-xs text-gray-500">({{ rand(10, 200) }})</span>
                            </div>
                            <div class="mt-3 flex items-center justify-between">
                                <p class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                <button type="button" 
                                        class="add-to-cart-btn px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        data-product-id="{{ $product->id }}"
                                        data-product-name="{{ $product->name }}">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const originalText = this.textContent;
            
            // Show loading state
            this.disabled = true;
            this.textContent = 'Adding...';
            
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
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = data.cart_count;
                    }
                    
                    // Show success feedback
                    this.textContent = 'Added!';
                    this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    this.classList.add('bg-green-600');
                    
                    // Reset after 2 seconds
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-green-600');
                        this.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        this.disabled = false;
                    }, 2000);
                } else {
                    this.textContent = 'Error';
                    this.classList.add('bg-red-600');
                    setTimeout(() => {
                        this.textContent = originalText;
                        this.classList.remove('bg-red-600');
                        this.disabled = false;
                    }, 2000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                this.textContent = 'Error';
                this.classList.add('bg-red-600');
                setTimeout(() => {
                    this.textContent = originalText;
                    this.classList.remove('bg-red-600');
                    this.disabled = false;
                }, 2000);
            });
        });
    });
});
</script>
@endpush
@endsection
