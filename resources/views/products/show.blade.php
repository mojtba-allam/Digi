@extends('layouts.app')

@section('title', $product->name ?? 'Product Details')

@section('content')
<div class="bg-white">
    <!-- Breadcrumb -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4" aria-label="Breadcrumb">
        <ol class="flex items-center space-x-2">
            <li>
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-gray-500">
                    <svg class="flex-shrink-0 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L9 5.414V17a1 1 0 102 0V5.414l5.293 5.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('products.index') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">Products</a>
                </div>
            </li>
            @if($product->categories->isNotEmpty())
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <a href="{{ route('categories.show', $product->categories->first()->id ?? '#') }}" class="ml-2 text-sm font-medium text-gray-500 hover:text-gray-700">
                        {{ $product->categories->first()->name ?? 'Category' }}
                    </a>
                </div>
            </li>
            @endif
            <li>
                <div class="flex items-center">
                    <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="ml-2 text-sm font-medium text-gray-900">{{ $product->name ?? 'Product' }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image Gallery -->
            <div class="flex flex-col-reverse">
                <!-- Image selector -->
                <div class="hidden mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-4 gap-6" aria-orientation="horizontal" role="tablist">
                        @for($i = 1; $i <= 4; $i++)
                        <button class="relative h-24 bg-white rounded-md flex items-center justify-center text-sm font-medium uppercase text-gray-900 cursor-pointer hover:bg-gray-50 focus:outline-none focus:ring focus:ring-offset-4 focus:ring-opacity-50" 
                                aria-controls="tabs-{{ $i }}-panel" 
                                role="tab" 
                                type="button">
                            <span class="sr-only">Image {{ $i }}</span>
                            <span class="absolute inset-0 rounded-md overflow-hidden bg-gradient-to-br from-blue-50 to-purple-50">
                                @php
                                    $thumbUrl = 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&size=300&background=667eea&color=ffffff&bold=true&format=svg';
                                @endphp
                                <img src="{{ $thumbUrl }}" 
                                     alt="Product image {{ $i }}" 
                                     class="w-full h-full object-center object-cover"
                                     loading="lazy">
                            </span>
                            <span class="absolute inset-0 rounded-md ring-2 ring-offset-2 ring-transparent pointer-events-none" aria-hidden="true"></span>
                        </button>
                        @endfor
                    </div>
                </div>

                <!-- Main image -->
                <div class="w-full aspect-w-1 aspect-h-1">
                    <div class="relative bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg overflow-hidden">
                        @php
                            $mainImageUrl = $product->image ?? ($product->media->isNotEmpty() ? $product->media->first()->url : 'https://ui-avatars.com/api/?name=' . urlencode($product->name) . '&size=600&background=667eea&color=ffffff&bold=true&format=svg');
                        @endphp
                        <img src="{{ $mainImageUrl }}" 
                             alt="{{ $product->name ?? 'Product' }}" 
                             class="w-full h-96 object-center object-cover sm:rounded-lg"
                             loading="lazy">
                        
                        <!-- Wishlist button -->
                        <button class="absolute top-4 right-4 p-2 bg-white rounded-full shadow-md hover:shadow-lg transition-shadow duration-200">
                            <svg class="w-6 h-6 text-gray-400 hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">{{ $product->name ?? 'Sample Product' }}</h1>

                <!-- Vendor info -->
                <div class="mt-3">
                    <p class="text-sm text-gray-500">
                        Sold by 
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            {{ $product->vendor->business_name ?? 'Sample Vendor' }}
                        </a>
                    </p>
                </div>

                <!-- Reviews -->
                <div class="mt-3">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                            <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            @endfor
                        </div>
                        <p class="ml-2 text-sm text-gray-900">4.8 out of 5 stars</p>
                        <a href="#reviews" class="ml-3 text-sm font-medium text-blue-600 hover:text-blue-500">{{ rand(50, 200) }} reviews</a>
                    </div>
                </div>

                <!-- Price -->
                <div class="mt-4">
                    <div class="flex items-center">
                        <p class="text-3xl font-bold text-gray-900">${{ $product->price ?? '99.99' }}</p>
                        @if(rand(0, 1))
                        <p class="ml-3 text-lg text-gray-500 line-through">${{ rand(120, 150) }}.99</p>
                        <p class="ml-2 text-sm font-medium text-green-600">Save {{ rand(10, 30) }}%</p>
                        @endif
                    </div>
                </div>

                <!-- Product variants -->
                <div class="mt-6">
                    <!-- Size selector -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Size</h3>
                        <fieldset class="mt-2">
                            <div class="grid grid-cols-3 gap-3 sm:grid-cols-6">
                                @foreach(['XS', 'S', 'M', 'L', 'XL', 'XXL'] as $size)
                                <label class="group relative border rounded-md py-3 px-3 flex items-center justify-center text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer bg-white text-gray-900 shadow-sm">
                                    <input type="radio" name="size" value="{{ $size }}" class="sr-only">
                                    <span>{{ $size }}</span>
                                    <span class="absolute -inset-px rounded-md pointer-events-none" aria-hidden="true"></span>
                                </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>

                    <!-- Color selector -->
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-900">Color</h3>
                        <fieldset class="mt-2">
                            <div class="flex items-center space-x-3">
                                @foreach(['bg-gray-900', 'bg-blue-600', 'bg-red-600', 'bg-green-600'] as $color)
                                <label class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-900">
                                    <input type="radio" name="color" value="{{ $color }}" class="sr-only">
                                    <span aria-hidden="true" class="h-8 w-8 {{ $color }} border border-black border-opacity-10 rounded-full"></span>
                                </label>
                                @endforeach
                            </div>
                        </fieldset>
                    </div>
                </div>

                <!-- Quantity and Add to Cart -->
                <form id="add-to-cart-form" class="mt-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex items-center space-x-4">
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                            <select id="quantity" name="quantity" class="mt-1 block w-20 pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                                @for($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="flex-1">
                            <button type="submit" id="add-to-cart-btn" class="w-full bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <span class="btn-text">Add to Cart</span>
                                <svg class="btn-loading hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Buy Now button -->
                    <button type="button" class="mt-3 w-full bg-gray-900 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900">
                        Buy Now
                    </button>
                </form>

                <!-- Product details -->
                <div class="mt-8">
                    <h3 class="text-sm font-medium text-gray-900">Description</h3>
                    <div class="mt-2 prose prose-sm text-gray-500">
                        <p>{{ $product->description ?? 'This is a sample product description. It provides detailed information about the product features, benefits, and specifications.' }}</p>
                    </div>
                </div>

                <!-- Product features -->
                <div class="mt-8">
                    <h3 class="text-sm font-medium text-gray-900">Features</h3>
                    <ul class="mt-2 list-disc list-inside text-sm text-gray-500 space-y-1">
                        <li>High-quality materials and construction</li>
                        <li>Comfortable and durable design</li>
                        <li>Available in multiple sizes and colors</li>
                        <li>Easy care and maintenance</li>
                        <li>30-day return policy</li>
                    </ul>
                </div>

                <!-- Shipping info -->
                <div class="mt-8 border-t border-gray-200 pt-8">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span class="text-sm text-gray-900">Free shipping on orders over $50</span>
                    </div>
                    <div class="flex items-center mt-2">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-900">Estimated delivery: 3-5 business days</span>
                    </div>
                    <div class="flex items-center mt-2">
                        <svg class="w-5 h-5 text-purple-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm text-gray-900">30-day return policy</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product tabs -->
        <div class="mt-16" x-data="{ activeTab: 'description' }">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <button @click="activeTab = 'description'" 
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'description', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'description' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                        Description
                    </button>
                    <button @click="activeTab = 'specifications'" 
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'specifications', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'specifications' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                        Specifications
                    </button>
                    <button @click="activeTab = 'reviews'" 
                            :class="{ 'border-blue-500 text-blue-600': activeTab === 'reviews', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'reviews' }"
                            class="py-4 px-1 border-b-2 font-medium text-sm">
                        Reviews ({{ rand(50, 200) }})
                    </button>
                </nav>
            </div>

            <!-- Tab content -->
            <div class="mt-8">
                <!-- Description tab -->
                <div x-show="activeTab === 'description'" class="prose max-w-none">
                    <h3>Product Description</h3>
                    <p>{{ $product->description ?? 'This is a comprehensive product description that provides detailed information about the product, its features, benefits, and how it can meet the customer\'s needs.' }}</p>
                    
                    <h4>Key Features</h4>
                    <ul>
                        <li>Premium quality materials</li>
                        <li>Innovative design and functionality</li>
                        <li>Durable construction for long-lasting use</li>
                        <li>Easy to use and maintain</li>
                        <li>Backed by manufacturer warranty</li>
                    </ul>
                </div>

                <!-- Specifications tab -->
                <div x-show="activeTab === 'specifications'">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Technical Specifications</h4>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">SKU</dt>
                                    <dd class="text-sm text-gray-900">{{ $product->sku ?? 'PROD-001' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Weight</dt>
                                    <dd class="text-sm text-gray-900">{{ rand(1, 10) }} lbs</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Dimensions</dt>
                                    <dd class="text-sm text-gray-900">{{ rand(10, 20) }}" x {{ rand(8, 15) }}" x {{ rand(5, 10) }}"</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Material</dt>
                                    <dd class="text-sm text-gray-900">Premium Cotton Blend</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Care Instructions</h4>
                            <ul class="text-sm text-gray-500 space-y-2">
                                <li>Machine wash cold with like colors</li>
                                <li>Do not bleach</li>
                                <li>Tumble dry low</li>
                                <li>Iron on low heat if needed</li>
                                <li>Do not dry clean</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Reviews tab -->
                <div x-show="activeTab === 'reviews'" id="reviews">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Review summary -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Customer Reviews</h4>
                            <div class="flex items-center mb-4">
                                <div class="flex items-center">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="text-yellow-400 h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    @endfor
                                </div>
                                <p class="ml-2 text-sm text-gray-900">4.8 out of 5</p>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">Based on {{ rand(50, 200) }} reviews</p>
                            
                            <!-- Rating breakdown -->
                            <div class="space-y-2">
                                @for($i = 5; $i >= 1; $i--)
                                <div class="flex items-center">
                                    <span class="text-sm text-gray-500 w-8">{{ $i }} star</span>
                                    <div class="flex-1 mx-3">
                                        <div class="bg-gray-200 rounded-full h-2">
                                            <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ rand(20, 90) }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500 w-8">{{ rand(5, 50) }}%</span>
                                </div>
                                @endfor
                            </div>
                        </div>

                        <!-- Individual reviews -->
                        <div class="lg:col-span-2">
                            <div class="space-y-6">
                                @for($i = 1; $i <= 3; $i++)
                                <div class="border-b border-gray-200 pb-6">
                                    <div class="flex items-center mb-2">
                                        <div class="flex items-center">
                                            @for($j = 1; $j <= 5; $j++)
                                            <svg class="text-yellow-400 h-4 w-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            @endfor
                                        </div>
                                        <p class="ml-2 text-sm font-medium text-gray-900">Customer {{ $i }}</p>
                                        <p class="ml-2 text-sm text-gray-500">{{ rand(1, 30) }} days ago</p>
                                    </div>
                                    <p class="text-sm text-gray-700">Great product! Really happy with the quality and fast shipping. Would definitely recommend to others.</p>
                                </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related products -->
        @if(isset($relatedProducts) && $relatedProducts->isNotEmpty())
        <div class="mt-16">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Related Products</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $related)
                <div class="group relative bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-t-lg bg-gradient-to-br from-blue-50 to-purple-50">
                        @php
                            $relatedImageUrl = $related->image ?? ($related->media->isNotEmpty() ? $related->media->first()->url : 'https://ui-avatars.com/api/?name=' . urlencode($related->name) . '&size=300&background=667eea&color=ffffff&bold=true&format=svg');
                        @endphp
                        <img src="{{ $relatedImageUrl }}" 
                             alt="{{ $related->name }}" 
                             class="h-48 w-full object-cover object-center group-hover:opacity-75 transition-opacity duration-200"
                             loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="{{ route('products.show', $related->id) }}" class="hover:text-blue-600">
                                {{ $related->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-lg font-bold text-gray-900">${{ $related->price }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addToCartForm = document.getElementById('add-to-cart-form');
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    const btnText = addToCartBtn.querySelector('.btn-text');
    const btnLoading = addToCartBtn.querySelector('.btn-loading');

    // Size and color selection
    let selectedSize = null;
    let selectedColor = null;

    // Size selection
    document.querySelectorAll('input[name="size"]').forEach(input => {
        input.addEventListener('change', function() {
            selectedSize = this.value;
            updateSelection();
        });
    });

    // Color selection
    document.querySelectorAll('input[name="color"]').forEach(input => {
        input.addEventListener('change', function() {
            selectedColor = this.value;
            updateSelection();
        });
    });

    function updateSelection() {
        // Update visual feedback for selections
        document.querySelectorAll('input[name="size"]').forEach(input => {
            const label = input.closest('label');
            if (input.checked) {
                label.classList.add('ring-2', 'ring-blue-500', 'bg-blue-50');
            } else {
                label.classList.remove('ring-2', 'ring-blue-500', 'bg-blue-50');
            }
        });

        document.querySelectorAll('input[name="color"]').forEach(input => {
            const label = input.closest('label');
            if (input.checked) {
                label.classList.add('ring-2', 'ring-blue-500');
            } else {
                label.classList.remove('ring-2', 'ring-blue-500');
            }
        });
    }

    // Add to cart form submission
    addToCartForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Show loading state
        addToCartBtn.disabled = true;
        btnText.textContent = 'Adding...';
        btnLoading.classList.remove('hidden');

        // Collect form data
        const formData = new FormData(this);
        
        // Add selected options as separate fields
        if (selectedSize) {
            formData.append('options[size]', selectedSize);
        }
        if (selectedColor) {
            formData.append('options[color]', selectedColor);
        }

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
                // Update cart count in navigation
                updateCartCount(data.cart_count);
                
                // Show success message
                showMessage(data.message, 'success');
                
                // Reset button
                resetButton();
            } else {
                showMessage(data.message, 'error');
                resetButton();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while adding the product to cart.', 'error');
            resetButton();
        });
    });

    function resetButton() {
        addToCartBtn.disabled = false;
        btnText.textContent = 'Add to Cart';
        btnLoading.classList.add('hidden');
    }

    function updateCartCount(count) {
        const cartCountElement = document.getElementById('cart-count');
        if (cartCountElement) {
            cartCountElement.textContent = count;
        }
    }

    function showMessage(message, type) {
        // Create and show a temporary message
        const messageDiv = document.createElement('div');
        messageDiv.className = `fixed top-4 right-4 z-50 p-4 rounded-md shadow-lg ${type === 'success' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-red-100 text-red-800 border border-red-200'}`;
        messageDiv.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span>${message}</span>
            </div>
        `;
        
        document.body.appendChild(messageDiv);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 4000);
    }
});
</script>
@endpush
@endsection