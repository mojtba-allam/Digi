@extends('layouts.app')

@section('title', 'Returns Policy')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 mb-8 border border-gray-100">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Returns & Refunds</h1>
                    <p class="text-gray-500 mt-1">Your satisfaction is our priority</p>
                </div>
            </div>
        </div>
        
        <div class="space-y-6">
            <!-- 30-Day Return Policy -->
            <section class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">30-Day Return Policy</h2>
                        <p class="text-gray-600 leading-relaxed">We want you to be completely satisfied with your purchase. If you're not happy, you can return most items within 30 days of delivery for a full refund.</p>
                    </div>
                </div>
            </section>

            <!-- Return Requirements -->
            <section class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="flex items-start mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Return Requirements</h2>
                        <div class="space-y-3">
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-gray-600">Items must be unused and in original condition</span>
                            </div>
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-gray-600">Original packaging must be included</span>
                            </div>
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-gray-600">Proof of purchase required</span>
                            </div>
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg">
                                <span class="w-2 h-2 bg-blue-500 rounded-full mt-2 mr-3 flex-shrink-0"></span>
                                <span class="text-gray-600">Some items may not be eligible for return</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- How to Return -->
            <section class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="flex items-start mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">How to Return</h2>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0 text-white font-bold">
                                    1
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-gray-600">Log into your account and go to Order History</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0 text-white font-bold">
                                    2
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-gray-600">Select the order and click "Request Return"</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0 text-white font-bold">
                                    3
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-gray-600">Print the return label and attach to package</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-lg flex items-center justify-center mr-4 flex-shrink-0 text-white font-bold">
                                    4
                                </div>
                                <div class="flex-1 pt-1">
                                    <p class="text-gray-600">Drop off at any authorized shipping location</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Refund Processing -->
            <section class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-8 border border-gray-100">
                <div class="flex items-start">
                    <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center mr-4 flex-shrink-0">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Refund Processing</h2>
                        <p class="text-gray-600 leading-relaxed">Refunds are processed within 5-7 business days after we receive your return. The refund will be issued to your original payment method. You'll receive an email confirmation once the refund has been processed.</p>
                    </div>
                </div>
            </section>

            <!-- CTA Section -->
            <section class="bg-gradient-to-br from-blue-600 to-purple-600 rounded-2xl shadow-xl p-8 text-white">
                <div class="text-center">
                    <h2 class="text-2xl font-bold mb-4">Need Help with a Return?</h2>
                    <p class="text-blue-100 mb-6">Our customer service team is here to assist you with any questions about returns or refunds.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('orders.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                            View My Orders
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 bg-white bg-opacity-20 text-blue-600 rounded-xl font-semibold hover:bg-opacity-30 transition-all duration-200">
                            Contact Support
                        </a>
                    </div>
                </div>
            </section>
        </div>

        <!-- Back Button -->
        <div class="mt-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Home
            </a>
        </div>
    </div>
</div>
@endsection
