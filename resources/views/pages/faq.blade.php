@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="bg-white min-h-screen">
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl font-bold mb-4">Frequently Asked Questions</h1>
            <p class="text-xl text-blue-100">Find answers to common questions</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="space-y-6" x-data="{ openFaq: null }">
            <!-- FAQ Item 1 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">How do I place an order?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 1" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">Browse our products, add items to your cart, and proceed to checkout. You'll need to create an account or log in to complete your purchase.</p>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">What payment methods do you accept?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 2" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">We accept all major credit cards (Visa, MasterCard, American Express), PayPal, and other secure payment methods.</p>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">How long does shipping take?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 3" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">Standard shipping typically takes 3-5 business days. Express shipping options are available at checkout for faster delivery.</p>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">What is your return policy?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 4 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 4" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">We offer a 30-day return policy for most items. Products must be unused and in original packaging. See our Returns page for full details.</p>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">How can I track my order?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 5 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 5" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">Once your order ships, you'll receive a tracking number via email. You can also track your order by logging into your account and viewing your order history.</p>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm">
                <button @click="openFaq = openFaq === 6 ? null : 6" class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50">
                    <span class="text-lg font-semibold text-gray-900">How do I become a vendor?</span>
                    <svg class="w-5 h-5 text-gray-500 transform transition-transform" :class="{ 'rotate-180': openFaq === 6 }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="openFaq === 6" x-collapse class="px-6 pb-4">
                    <p class="text-gray-600">Click on "Join as Vendor" in the navigation menu to register. You'll need to provide business information and complete our verification process.</p>
                </div>
            </div>
        </div>

        <!-- Still have questions? -->
        <div class="mt-12 bg-gradient-to-r from-blue-50 to-purple-50 rounded-xl p-8 text-center">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Still have questions?</h3>
            <p class="text-gray-600 mb-6">Can't find the answer you're looking for? Please contact our support team.</p>
            <a href="{{ route('contact') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg font-semibold hover:shadow-lg transition-all duration-200">
                Contact Support
            </a>
        </div>
    </div>
</div>
@endsection
