@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
            <div class="mt-4 flex items-center">
                <div class="flex items-center text-sm text-blue-600">
                    <span class="flex items-center justify-center w-6 h-6 bg-blue-600 text-white rounded-full text-xs font-medium mr-2">1</span>
                    Shipping
                </div>
                <div class="flex-1 border-t border-gray-300 mx-4"></div>
                <div class="flex items-center text-sm text-gray-400">
                    <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-white rounded-full text-xs font-medium mr-2">2</span>
                    Payment
                </div>
                <div class="flex-1 border-t border-gray-300 mx-4"></div>
                <div class="flex items-center text-sm text-gray-400">
                    <span class="flex items-center justify-center w-6 h-6 bg-gray-300 text-white rounded-full text-xs font-medium mr-2">3</span>
                    Review
                </div>
            </div>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
            @csrf
            <div class="lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16">
                <!-- Checkout Form -->
                <div>
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h2>
                        
                        @guest
                        <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-md">
                            <p class="text-sm text-blue-800">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">Sign in</a> 
                                for a faster checkout experience.
                            </p>
                        </div>
                        @endguest

                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', Auth::user()->email ?? '') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h2>
                        
                        @if(Auth::check() && $addresses->isNotEmpty())
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Saved Addresses</label>
                            <div class="space-y-2">
                                <label class="flex items-start">
                                    <input type="radio" name="use_saved_address" value="new" checked class="mt-1 mr-3">
                                    <span class="text-sm text-gray-900">Use new address</span>
                                </label>
                                @foreach($addresses as $address)
                                <label class="flex items-start">
                                    <input type="radio" name="use_saved_address" value="{{ $address->id }}" class="mt-1 mr-3">
                                    <div class="text-sm text-gray-900">
                                        <div>{{ $address->first_name }} {{ $address->last_name }}</div>
                                        <div>{{ $address->address_line_1 }}</div>
                                        @if($address->address_line_2)
                                        <div>{{ $address->address_line_2 }}</div>
                                        @endif
                                        <div>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</div>
                                        <div>{{ $address->country }}</div>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div id="address-form" class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" 
                                       id="first_name" 
                                       name="first_name" 
                                       value="{{ old('first_name') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror">
                                @error('first_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" 
                                       id="last_name" 
                                       name="last_name" 
                                       value="{{ old('last_name') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror">
                                @error('last_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       value="{{ old('phone') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-500 @enderror">
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address_line_1" class="block text-sm font-medium text-gray-700">Address</label>
                                <input type="text" 
                                       id="address_line_1" 
                                       name="address_line_1" 
                                       value="{{ old('address_line_1') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('address_line_1') border-red-500 @enderror">
                                @error('address_line_1')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address_line_2" class="block text-sm font-medium text-gray-700">Apartment, suite, etc. (optional)</label>
                                <input type="text" 
                                       id="address_line_2" 
                                       name="address_line_2" 
                                       value="{{ old('address_line_2') }}" 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input type="text" 
                                       id="city" 
                                       name="city" 
                                       value="{{ old('city') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('city') border-red-500 @enderror">
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700">State / Province</label>
                                <input type="text" 
                                       id="state" 
                                       name="state" 
                                       value="{{ old('state') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('state') border-red-500 @enderror">
                                @error('state')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input type="text" 
                                       id="postal_code" 
                                       name="postal_code" 
                                       value="{{ old('postal_code') }}" 
                                       required 
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('postal_code') border-red-500 @enderror">
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <select id="country" 
                                        name="country" 
                                        required 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('country') border-red-500 @enderror">
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country') == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country') == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('country') == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="AU" {{ old('country') == 'AU' ? 'selected' : '' }}>Australia</option>
                                </select>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        @auth
                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="save_address" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Save this address for future orders</span>
                            </label>
                        </div>
                        @endauth
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h2>
                        
                        <div class="space-y-4">
                            <!-- Credit Card -->
                            <label class="flex items-start">
                                <input type="radio" name="payment_method" value="credit_card" checked class="mt-1 mr-3">
                                <div class="flex-1">
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium text-gray-900">Credit Card</span>
                                        <div class="ml-2 flex space-x-1">
                                            <img src="https://via.placeholder.com/32x20/1a365d/ffffff?text=VISA" alt="Visa" class="h-5">
                                            <img src="https://via.placeholder.com/32x20/dc2626/ffffff?text=MC" alt="Mastercard" class="h-5">
                                            <img src="https://via.placeholder.com/32x20/059669/ffffff?text=AMEX" alt="American Express" class="h-5">
                                        </div>
                                    </div>
                                    
                                    <div id="credit-card-form" class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div class="sm:col-span-2">
                                            <label for="card_number" class="block text-sm font-medium text-gray-700">Card Number</label>
                                            <input type="text" 
                                                   id="card_number" 
                                                   name="card_number" 
                                                   placeholder="1234 5678 9012 3456"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('card_number') border-red-500 @enderror">
                                            @error('card_number')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label for="card_name" class="block text-sm font-medium text-gray-700">Name on Card</label>
                                            <input type="text" 
                                                   id="card_name" 
                                                   name="card_name" 
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('card_name') border-red-500 @enderror">
                                            @error('card_name')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="card_expiry" class="block text-sm font-medium text-gray-700">Expiry Date</label>
                                            <input type="text" 
                                                   id="card_expiry" 
                                                   name="card_expiry" 
                                                   placeholder="MM/YY"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('card_expiry') border-red-500 @enderror">
                                            @error('card_expiry')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label for="card_cvc" class="block text-sm font-medium text-gray-700">CVC</label>
                                            <input type="text" 
                                                   id="card_cvc" 
                                                   name="card_cvc" 
                                                   placeholder="123"
                                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('card_cvc') border-red-500 @enderror">
                                            @error('card_cvc')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- PayPal -->
                            <label class="flex items-start">
                                <input type="radio" name="payment_method" value="paypal" class="mt-1 mr-3">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900">PayPal</span>
                                    <img src="https://via.placeholder.com/60x20/003087/ffffff?text=PayPal" alt="PayPal" class="ml-2 h-5">
                                </div>
                            </label>

                            <!-- Stripe -->
                            <label class="flex items-start">
                                <input type="radio" name="payment_method" value="stripe" class="mt-1 mr-3">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900">Stripe</span>
                                    <img src="https://via.placeholder.com/60x20/635bff/ffffff?text=Stripe" alt="Stripe" class="ml-2 h-5">
                                </div>
                            </label>
                        </div>

                        @error('payment_method')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                        
                        <!-- Order Items -->
                        <div class="space-y-4 mb-6">
                            @foreach($cart->items as $item)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img src="https://via.placeholder.com/80x80/f3f4f6/9ca3af?text={{ urlencode($item->product->name) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="h-16 w-16 rounded-md object-cover">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-gray-900">{{ $item->display_name }}</h4>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    ${{ number_format($item->total, 2) }}
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="border-t border-gray-200 pt-4 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium text-gray-900">${{ number_format($cart->subtotal, 2) }}</span>
                            </div>
                            
                            @if($cart->discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-medium text-green-600">-${{ number_format($cart->discount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-medium text-gray-900">
                                    @if($cart->subtotal >= 50)
                                        <span class="text-green-600">Free</span>
                                    @else
                                        $9.99
                                    @endif
                                </span>
                            </div>
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax</span>
                                <span class="font-medium text-gray-900">${{ number_format($cart->subtotal * 0.08, 2) }}</span>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between text-base font-medium">
                                    <span class="text-gray-900">Total</span>
                                    <span class="text-gray-900">
                                        ${{ number_format($cart->total + ($cart->subtotal >= 50 ? 0 : 9.99) + ($cart->subtotal * 0.08), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Place Order Button -->
                        <div class="mt-6">
                            <button type="submit" 
                                    id="place-order-btn"
                                    class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                <span class="btn-text">Place Order</span>
                                <svg class="btn-loading hidden animate-spin -ml-1 mr-3 h-5 w-5 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Security Info -->
                        <div class="mt-4 flex items-center justify-center text-sm text-gray-500">
                            <svg class="h-4 w-4 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Your payment information is secure
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkoutForm = document.getElementById('checkout-form');
    const placeOrderBtn = document.getElementById('place-order-btn');
    const btnText = placeOrderBtn.querySelector('.btn-text');
    const btnLoading = placeOrderBtn.querySelector('.btn-loading');

    // Payment method handling
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    const creditCardForm = document.getElementById('credit-card-form');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function() {
            if (this.value === 'credit_card') {
                creditCardForm.style.display = 'grid';
                // Make credit card fields required
                creditCardForm.querySelectorAll('input').forEach(input => {
                    input.required = true;
                });
            } else {
                creditCardForm.style.display = 'none';
                // Remove required from credit card fields
                creditCardForm.querySelectorAll('input').forEach(input => {
                    input.required = false;
                });
            }
        });
    });

    // Card number formatting
    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function() {
            let value = this.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            this.value = formattedValue;
        });
    }

    // Expiry date formatting
    const cardExpiryInput = document.getElementById('card_expiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length >= 2) {
                value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
            this.value = value;
        });
    }

    // Form submission
    checkoutForm.addEventListener('submit', function(e) {
        // Show loading state
        placeOrderBtn.disabled = true;
        btnText.textContent = 'Processing...';
        btnLoading.classList.remove('hidden');
    });

    // Saved address handling
    const savedAddressRadios = document.querySelectorAll('input[name="use_saved_address"]');
    const addressForm = document.getElementById('address-form');

    savedAddressRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'new') {
                addressForm.style.display = 'grid';
                // Make address fields required
                addressForm.querySelectorAll('input[required], select[required]').forEach(input => {
                    input.required = true;
                });
            } else {
                addressForm.style.display = 'none';
                // Remove required from address fields
                addressForm.querySelectorAll('input, select').forEach(input => {
                    input.required = false;
                });
            }
        });
    });
});
</script>
@endpush
@endsection