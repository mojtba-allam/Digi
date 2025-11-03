@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="border-b border-gray-200 pb-6">
            <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Orders</h1>
            <p class="mt-2 text-sm text-gray-500">Track and manage your orders</p>
        </div>

        <!-- Orders List -->
        <div class="mt-8">
            @forelse(range(1, 3) as $i)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm mb-6">
                <!-- Order Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Order #ORD-2024-{{ str_pad($i, 6, '0', STR_PAD_LEFT) }}</h3>
                            <p class="text-sm text-gray-500">Placed on {{ now()->subDays(rand(1, 30))->format('M d, Y') }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $i === 1 ? 'bg-green-100 text-green-800' : ($i === 2 ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $i === 1 ? 'Delivered' : ($i === 2 ? 'Shipped' : 'Processing') }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-lg font-semibold text-gray-900">${{ number_format(rand(50, 500), 2) }}</p>
                        <p class="text-sm text-gray-500">{{ rand(1, 5) }} items</p>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @for($j = 1; $j <= rand(1, 3); $j++)
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="https://via.placeholder.com/80x80/f3f4f6/9ca3af?text=Product+{{ $j }}" 
                                     alt="Product {{ $j }}" 
                                     class="h-16 w-16 rounded-md object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900">Sample Product {{ $j }}</h4>
                                <p class="text-sm text-gray-500">Qty: {{ rand(1, 3) }}</p>
                                <p class="text-sm text-gray-500">SKU: PROD-{{ str_pad($j, 3, '0', STR_PAD_LEFT) }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">${{ number_format(rand(20, 100), 2) }}</p>
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
                    <div class="flex space-x-3">
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">View Details</a>
                        @if($i === 1)
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Return Items</a>
                        @endif
                        @if($i === 2)
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Track Package</a>
                        @endif
                    </div>
                    <div class="flex space-x-3">
                        <a href="#" class="text-sm font-medium text-gray-600 hover:text-gray-500">Download Invoice</a>
                        <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500">Reorder</a>
                    </div>
                </div>
            </div>
            @empty
            <!-- Empty State -->
            <div class="text-center py-16">
                <svg class="mx-auto h-24 w-24 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
                <p class="mt-2 text-sm text-gray-500">Start shopping to see your orders here.</p>
                <div class="mt-6">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Start Shopping
                    </a>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(count(range(1, 3)) > 0)
        <div class="mt-8 flex items-center justify-between border-t border-gray-200 pt-6">
            <div class="flex-1 flex justify-between sm:hidden">
                <a href="#" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Previous
                </a>
                <a href="#" class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                    Next
                </a>
            </div>
            
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700">
                        Showing <span class="font-medium">1</span> to <span class="font-medium">3</span> of <span class="font-medium">3</span> orders
                    </p>
                </div>
                <div>
                    <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Previous</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">1</a>
                        <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                            <span class="sr-only">Next</span>
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </nav>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection