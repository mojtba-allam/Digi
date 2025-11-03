@extends('layouts.app')

@section('title', 'Help Center')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">How Can We Help?</h1>
            <p class="text-xl text-gray-600">Find answers and get support</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <a href="{{ route('faq') }}" class="bg-white rounded-xl shadow-sm p-8 hover:shadow-lg transition-shadow">
                <div class="bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">FAQ</h3>
                <p class="text-gray-600">Find answers to frequently asked questions</p>
            </a>

            <a href="{{ route('shipping-info') }}" class="bg-white rounded-xl shadow-sm p-8 hover:shadow-lg transition-shadow">
                <div class="bg-green-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Shipping Info</h3>
                <p class="text-gray-600">Learn about our shipping options</p>
            </a>

            <a href="{{ route('returns') }}" class="bg-white rounded-xl shadow-sm p-8 hover:shadow-lg transition-shadow">
                <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Returns</h3>
                <p class="text-gray-600">Information about returns and refunds</p>
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Still Need Help?</h2>
            <p class="text-gray-600 mb-6">Our support team is here to assist you</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-200">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
