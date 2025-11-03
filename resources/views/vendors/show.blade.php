@extends('layouts.app')

@section('title', $vendor->company_name)

@section('content')
<div class="bg-white">
    <!-- Vendor Header -->
    <div class="relative bg-gray-50 border-b border-gray-200">
        <!-- Banner with overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://picsum.photos/seed/vendor-{{ $vendor->id }}/1200/250" 
                 alt="{{ $vendor->company_name }}" 
                 class="w-full h-full object-cover opacity-15">
        </div>
        
        <!-- Vendor Info -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="text-center">
                <!-- Avatar -->
                <div class="inline-block">
                    <div class="h-24 w-24 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center mx-auto">
                        <span class="text-3xl font-bold text-blue-600">
                            {{ strtoupper(substr($vendor->company_name, 0, 2)) }}
                        </span>
                    </div>
                </div>
                
                <!-- Company Name -->
                <h1 class="mt-4 text-3xl sm:text-4xl font-bold text-gray-900">
                    {{ $vendor->company_name }}
                </h1>
                
                <!-- Stats -->
                <div class="mt-6 flex flex-wrap items-center justify-center gap-4 text-gray-700">
                    <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        <span class="font-semibold text-gray-900">{{ $vendor->products_count }}</span>
                        <span class="ml-1">{{ Str::plural('Product', $vendor->products_count) }}</span>
                    </div>
                    
                    <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200">
                        <div class="flex items-center mr-2">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="text-yellow-400 h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <span class="font-semibold text-gray-900">4.8</span>
                        <span class="ml-1">({{ rand(50, 200) }} reviews)</span>
                    </div>
                    
                    <div class="flex items-center bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Member since {{ $vendor->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900">Products from {{ $vendor->company_name }}</h2>
            <p class="mt-1 text-sm text-gray-500">Browse all products from this vendor</p>
        </div>

        @if($products->isEmpty())
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No products yet</h3>
            <p class="mt-1 text-sm text-gray-500">This vendor hasn't listed any products yet</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="group relative bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gradient-to-br from-blue-50 to-purple-50">
                    <a href="{{ route('products.show', $product->id) }}">
                        @php
                            $vendorProductImageUrl = $product->image ?? ($product->media->isNotEmpty() ? $product->media->first()->url : 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&size=300&background=667eea&color=ffffff&bold=true&format=svg');
                        @endphp
                        <img src="{{ $vendorProductImageUrl }}" 
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
                                class="add-to-cart-btn px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
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
