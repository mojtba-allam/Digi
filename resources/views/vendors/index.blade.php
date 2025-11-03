@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="text-center">
                <h1 class="text-4xl font-bold text-gray-900">Our Trusted Vendors</h1>
                <p class="mt-3 text-lg text-gray-600">Discover quality products from verified sellers</p>
                <div class="mt-4 flex items-center justify-center gap-2 text-sm text-gray-500">
                    <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $vendors->total() }} active vendors with products</span>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($vendors->isEmpty())
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No vendors available</h3>
            <p class="mt-2 text-sm text-gray-500">Check back later for new vendors with products</p>
        </div>
        @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($vendors as $vendor)
            <a href="{{ route('vendors.show', $vendor->id) }}" class="group bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100">
                <!-- Vendor Banner -->
                <div class="h-28 bg-gradient-to-br from-blue-500 via-purple-500 to-pink-500 relative overflow-hidden">
                    @php
                        $vendorBanner = 'https://ui-avatars.com/api/?name=' . urlencode($vendor->company_name) . '&size=400&background=random&color=ffffff&bold=true&format=svg';
                    @endphp
                    <img src="{{ $vendorBanner }}" 
                         alt="{{ $vendor->company_name }}" 
                         class="w-full h-full object-cover opacity-20 group-hover:opacity-30 transition-opacity duration-300"
                         loading="lazy">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black opacity-30"></div>
                </div>
                
                <!-- Vendor Info -->
                <div class="p-5 -mt-10">
                    <div class="flex flex-col items-center text-center">
                        <!-- Avatar -->
                        <div class="relative">
                            <div class="h-20 w-20 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                <span class="text-2xl font-bold bg-gradient-to-br from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                    {{ strtoupper(substr($vendor->company_name, 0, 2)) }}
                                </span>
                            </div>
                            <!-- Verified Badge -->
                            <div class="absolute -bottom-1 -right-1 bg-green-500 rounded-full p-1 border-2 border-white">
                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        
                        <!-- Company Name -->
                        <h3 class="mt-3 text-base font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 px-2 min-h-[3rem]">
                            {{ $vendor->company_name }}
                        </h3>
                    </div>
                    
                    <!-- Stats -->
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-gray-600">
                                <svg class="w-4 h-4 mr-1.5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span class="font-semibold text-gray-900">{{ $vendor->products_count }}</span>
                                <span class="ml-1">{{ Str::plural('item', $vendor->products_count) }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="text-yellow-400 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="ml-1 font-semibold text-gray-900">4.8</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- View Store Button -->
                    <div class="mt-4">
                        <div class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-2 rounded-lg font-medium text-sm group-hover:shadow-md transition-shadow duration-300">
                            View Store
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $vendors->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
