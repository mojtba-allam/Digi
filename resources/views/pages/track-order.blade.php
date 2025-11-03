@extends('layouts.app')

@section('title', 'Track Order')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Track Your Order</h1>
            <p class="text-xl text-gray-600">Enter your order number to track your shipment</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8">
            <form class="space-y-6">
                @csrf
                <div>
                    <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">Order Number</label>
                    <input type="text" id="order_number" name="order_number" placeholder="e.g., ORD-123456" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="your@email.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 px-6 rounded-lg font-semibold hover:shadow-lg transition-all duration-200">
                    Track Order
                </button>
            </form>

            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-sm text-gray-600 text-center">
                    You can also track your order by logging into your account and viewing your order history.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
