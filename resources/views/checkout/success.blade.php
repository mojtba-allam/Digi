@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Success Icon -->
        <div class="text-center">
            <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-8">Thank you for your purchase. Your order has been successfully placed.</p>
        </div>

        <!-- Order Details -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Order Number</h3>
                    <p class="text-lg font-semibold text-blue-600">{{ $order->order_number }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Order Date</h3>
                    <p class="text-lg text-gray-900">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Total Amount</h3>
                    <p class="text-lg font-semibold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                </div>
                <div>
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Payment Status</h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        {{ ucfirst($order->payment->status ?? 'Completed') }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white border border-gray-200 rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Order Items</h2>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center space-x-4">
                    <div class="flex-shrink-0">
                        <img src="https://via.placeholder.com/80x80/f3f4f6/9ca3af?text={{ urlencode($item->product_name) }}" 
                             alt="{{ $item->product_name }}" 
                             class="h-16 w-16 rounded-md object-cover">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                        <p class="text-sm text-gray-500">SKU: {{ $item->product_sku }}</p>
                        @if($item->product_options)
                            <div class="mt-1">
                                @foreach(json_decode($item->product_options, true) as $key => $value)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800 mr-1">
                                        {{ ucfirst($key) }}: {{ $value }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                        <p class="text-sm font-medium text-gray-900">${{ number_format($item->total, 2) }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="bg-white border border-gray-200 rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Order Summary</h2>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                @if($order->discount_amount > 0)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Discount</span>
                    <span class="font-medium text-green-600">-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
                @endif
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium text-gray-900">
                        @if($order->shipping_amount == 0)
                            <span class="text-green-600">Free</span>
                        @else
                            ${{ number_format($order->shipping_amount, 2) }}
                        @endif
                    </span>
                </div>
                
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium text-gray-900">${{ number_format($order->tax_amount, 2) }}</span>
                </div>
                
                <div class="border-t border-gray-200 pt-3">
                    <div class="flex justify-between text-base font-medium">
                        <span class="text-gray-900">Total</span>
                        <span class="text-gray-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white border border-gray-200 rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Shipping Address</h2>
            </div>
            <div class="px-6 py-4">
                @php
                    $shippingAddress = json_decode($order->shipping_address, true);
                @endphp
                <div class="text-sm text-gray-900">
                    <p class="font-medium">{{ $shippingAddress['first_name'] }} {{ $shippingAddress['last_name'] }}</p>
                    <p>{{ $shippingAddress['address_line_1'] }}</p>
                    @if($shippingAddress['address_line_2'])
                        <p>{{ $shippingAddress['address_line_2'] }}</p>
                    @endif
                    <p>{{ $shippingAddress['city'] }}, {{ $shippingAddress['state'] }} {{ $shippingAddress['postal_code'] }}</p>
                    <p>{{ $shippingAddress['country'] }}</p>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        @if($order->payment)
        <div class="bg-white border border-gray-200 rounded-lg mb-8">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Payment Information</h2>
            </div>
            <div class="px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Payment Method</p>
                        <p class="text-sm text-gray-500">{{ ucfirst(str_replace('_', ' ', $order->payment->payment_method)) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-900">${{ number_format($order->payment->amount, 2) }}</p>
                        <p class="text-sm text-gray-500">Transaction ID: {{ $order->payment->transaction_id }}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
            <h3 class="text-lg font-medium text-blue-900 mb-4">What's Next?</h3>
            <div class="space-y-3 text-sm text-blue-800">
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Order Confirmation Email</p>
                        <p>We've sent a confirmation email to {{ json_decode($order->billing_address, true)['email'] }} with your order details.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Processing & Shipping</p>
                        <p>Your order will be processed within 1-2 business days and shipped via standard delivery (3-5 business days).</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <svg class="h-5 w-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div>
                        <p class="font-medium">Order Tracking</p>
                        <p>You'll receive tracking information once your order ships. You can also track your order in your account.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            @auth
            <a href="{{ route('orders.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                View All Orders
            </a>
            @endauth
            
            <a href="{{ route('products.index') }}" 
               class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Continue Shopping
            </a>
        </div>

        <!-- Customer Support -->
        <div class="mt-12 text-center">
            <p class="text-sm text-gray-500">
                Need help with your order? 
                <a href="#" class="font-medium text-blue-600 hover:text-blue-500">Contact our support team</a>
            </p>
        </div>
    </div>
</div>
@endsection