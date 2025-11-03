@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Shopping Cart</h1>
            <p class="mt-2 text-gray-600">
                @if($cart->total_items > 0)
                    <span class="inline-flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        {{ $cart->total_items }} {{ Str::plural('item', $cart->total_items) }} in your cart
                    </span>
                @else
                    Your cart is empty
                @endif
            </p>
        </div>

        @if($cart->isEmpty())
            <!-- Empty Cart -->
            <div class="bg-white rounded-2xl shadow-xl p-12 text-center border border-gray-100">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">Your cart is empty</h3>
                <p class="text-gray-600 mb-8">Start shopping to add items to your cart and enjoy our amazing products!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-xl font-semibold hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Start Shopping
                </a>
            </div>
        @else
            <div class="lg:grid lg:grid-cols-12 lg:gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-7 space-y-4">
                    @foreach($cart->items as $item)
                    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition-all duration-300 p-6 border border-gray-100" data-item-id="{{ $item->id }}">
                        <div class="flex items-start space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 rounded-xl overflow-hidden bg-gradient-to-br from-blue-50 to-purple-50">
                                    @php
                                        $cartImageUrl = null;
                                        if (isset($item->product->image) && $item->product->image) {
                                            $cartImageUrl = $item->product->image;
                                        } elseif (isset($item->product->media) && $item->product->media->isNotEmpty()) {
                                            $cartImageUrl = $item->product->media->first()->url;
                                        } else {
                                            $cartImageUrl = 'https://ui-avatars.com/api/?name=' . urlencode($item->product->name) . '&size=150&background=667eea&color=ffffff&bold=true&format=svg';
                                        }
                                    @endphp
                                    <img src="{{ $cartImageUrl }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="w-full h-full object-cover"
                                         loading="lazy">
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-gray-900 mb-1">
                                    <a href="{{ route('products.show', $item->product->id) }}" class="hover:text-blue-600 transition-colors duration-200">
                                        {{ $item->display_name }}
                                    </a>
                                </h3>
                                
                                @if($item->product->vendor)
                                <p class="text-sm text-gray-500 mb-3 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                    </svg>
                                    Sold by {{ $item->product->vendor->business_name }}
                                </p>
                                @endif

                                <div class="flex items-center justify-between">
                                    <!-- Quantity Selector -->
                                    <div class="flex items-center bg-gray-50 border-2 border-gray-200 rounded-xl overflow-hidden">
                                        <button type="button" 
                                                class="quantity-btn p-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200" 
                                                data-action="decrease" 
                                                data-item-id="{{ $item->id }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" 
                                               value="{{ $item->quantity }}" 
                                               min="1" 
                                               max="99"
                                               class="quantity-input w-16 text-center border-0 bg-transparent focus:ring-0 focus:outline-none font-semibold text-gray-900" 
                                               data-item-id="{{ $item->id }}">
                                        <button type="button" 
                                                class="quantity-btn p-3 text-gray-600 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200" 
                                                data-action="increase" 
                                                data-item-id="{{ $item->id }}">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Price -->
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Unit Price</p>
                                        <p class="text-lg font-bold text-gray-900">${{ number_format($item->price, 2) }}</p>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-100">
                                    <button type="button" 
                                            class="remove-item inline-flex items-center text-sm font-medium text-red-600 hover:text-red-700 transition-colors duration-200" 
                                            data-item-id="{{ $item->id }}">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Remove
                                    </button>
                                    <div class="text-right">
                                        <p class="text-sm text-gray-500">Subtotal</p>
                                        <p class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">${{ number_format($item->total, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <!-- Cart Actions -->
                    <div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100">
                        <div class="flex items-center justify-between">
                            <button type="button" 
                                    id="clear-cart" 
                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Clear Cart
                            </button>
                            <a href="{{ route('products.index') }}" 
                               class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Continue Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-5 mt-8 lg:mt-0">
                    <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 sticky top-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h2>
                        
                        <!-- Coupon Code -->
                        <div class="mb-6">
                            <label for="coupon-code" class="block text-sm font-semibold text-gray-700 mb-2">
                                Have a Coupon Code?
                            </label>
                            <div class="flex space-x-2">
                                <input type="text" 
                                       id="coupon-code" 
                                       name="coupon_code"
                                       placeholder="Enter code" 
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                                <button type="button" 
                                        id="apply-coupon" 
                                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-xl hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                    Apply
                                </button>
                            </div>
                        </div>

                        <!-- Applied Coupons -->
                        @if($cart->coupons->isNotEmpty())
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold text-gray-700 mb-3">Applied Coupons</h3>
                            @foreach($cart->coupons as $coupon)
                            <div class="flex items-center justify-between bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-4 mb-2">
                                <div>
                                    <p class="text-sm font-bold text-green-800">{{ $coupon->code }}</p>
                                    <p class="text-xs text-green-600">{{ $coupon->description }}</p>
                                </div>
                                <button type="button" 
                                        class="remove-coupon w-8 h-8 flex items-center justify-center bg-green-200 hover:bg-green-300 rounded-lg text-green-700 transition-colors duration-200" 
                                        data-coupon-id="{{ $coupon->id }}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @endforeach
                        </div>
                        @endif

                        <!-- Price Breakdown -->
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal ({{ $cart->total_items }} items)</span>
                                <span class="font-semibold text-gray-900" id="cart-subtotal">${{ number_format($cart->subtotal, 2) }}</span>
                            </div>
                            
                            @if($cart->discount > 0)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Discount</span>
                                <span class="font-semibold text-green-600" id="cart-discount">-${{ number_format($cart->discount, 2) }}</span>
                            </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold">
                                    @if($cart->total >= 50)
                                        <span class="text-green-600 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Free
                                        </span>
                                    @else
                                        <span class="text-gray-900">$9.99</span>
                                    @endif
                                </span>
                            </div>
                            
                            @if($cart->total < 50)
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                <p class="text-xs text-blue-700">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Add ${{ number_format(50 - $cart->total, 2) }} more to get free shipping!
                                </p>
                            </div>
                            @endif
                            
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Tax (8%)</span>
                                <span class="font-semibold text-gray-900">${{ number_format($cart->total * 0.08, 2) }}</span>
                            </div>
                            
                            <div class="border-t-2 border-gray-200 pt-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-gray-900">Total</span>
                                    <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent" id="cart-total">
                                        ${{ number_format($cart->total + ($cart->total >= 50 ? 0 : 9.99) + ($cart->total * 0.08), 2) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Checkout Button -->
                        <div class="space-y-3">
                            <a href="{{ route('checkout.index') }}" 
                               class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white text-center py-4 px-6 rounded-xl font-bold text-lg hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Proceed to Checkout
                            </a>

                            <!-- Security Badge -->
                            <div class="flex items-center justify-center text-sm text-gray-500 space-x-4">
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-green-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Secure Checkout
                                </div>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 text-blue-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                    SSL Encrypted
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badges -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-500 text-center mb-3">We Accept</p>
                            <div class="flex items-center justify-center space-x-3">
                                <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <svg class="h-6" viewBox="0 0 48 32" fill="none">
                                        <rect width="48" height="32" rx="4" fill="#1434CB"/>
                                        <text x="24" y="20" text-anchor="middle" fill="white" font-size="10" font-weight="bold">VISA</text>
                                    </svg>
                                </div>
                                <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <svg class="h-6" viewBox="0 0 48 32" fill="none">
                                        <rect width="48" height="32" rx="4" fill="#EB001B"/>
                                        <circle cx="18" cy="16" r="8" fill="#FF5F00"/>
                                        <circle cx="30" cy="16" r="8" fill="#F79E1B"/>
                                    </svg>
                                </div>
                                <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <svg class="h-6" viewBox="0 0 48 32" fill="none">
                                        <rect width="48" height="32" rx="4" fill="#016FD0"/>
                                        <text x="24" y="20" text-anchor="middle" fill="white" font-size="8" font-weight="bold">AMEX</text>
                                    </svg>
                                </div>
                                <div class="w-12 h-8 bg-gray-100 rounded flex items-center justify-center">
                                    <svg class="h-6" viewBox="0 0 48 32" fill="none">
                                        <rect width="48" height="32" rx="4" fill="#00457C"/>
                                        <text x="24" y="20" text-anchor="middle" fill="white" font-size="7" font-weight="bold">PayPal</text>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Quantity update handlers
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const action = this.dataset.action;
            const itemId = this.dataset.itemId;
            const input = document.querySelector(`.quantity-input[data-item-id="${itemId}"]`);
            let quantity = parseInt(input.value);

            if (action === 'increase') {
                quantity = Math.min(quantity + 1, 99);
            } else if (action === 'decrease') {
                quantity = Math.max(quantity - 1, 1);
            }

            input.value = quantity;
            updateCartItem(itemId, quantity);
        });
    });

    // Direct quantity input
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = Math.max(1, Math.min(99, parseInt(this.value) || 1));
            this.value = quantity;
            updateCartItem(itemId, quantity);
        });
    });

    // Remove item handlers
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            if (confirm('Remove this item from your cart?')) {
                removeCartItem(itemId);
            }
        });
    });

    // Clear cart handler
    document.getElementById('clear-cart')?.addEventListener('click', function() {
        if (confirm('Are you sure you want to clear your entire cart?')) {
            clearCart();
        }
    });

    // Apply coupon handler
    document.getElementById('apply-coupon')?.addEventListener('click', function() {
        const couponCode = document.getElementById('coupon-code').value.trim();
        if (couponCode) {
            applyCoupon(couponCode);
        } else {
            showMessage('Please enter a coupon code', 'error');
        }
    });

    // Remove coupon handlers
    document.querySelectorAll('.remove-coupon').forEach(button => {
        button.addEventListener('click', function() {
            const couponId = this.dataset.couponId;
            removeCoupon(couponId);
        });
    });

    // Functions
    function updateCartItem(itemId, quantity) {
        fetch(`/cart/update/${itemId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateCartSummary(data.cart);
                showMessage(data.message, 'success');
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while updating the cart.', 'error');
        });
    }

    function removeCartItem(itemId) {
        fetch(`/cart/remove/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                itemElement.style.transform = 'translateX(-100%)';
                itemElement.style.opacity = '0';
                setTimeout(() => {
                    itemElement.remove();
                }, 300);
                
                updateCartSummary(data.cart);
                showMessage(data.message, 'success');
                
                // Reload page if cart is empty
                if (data.cart.total_items === 0) {
                    setTimeout(() => location.reload(), 1000);
                }
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while removing the item.', 'error');
        });
    }

    function clearCart() {
        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Cart cleared successfully!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while clearing the cart.', 'error');
        });
    }

    function applyCoupon(couponCode) {
        const button = document.getElementById('apply-coupon');
        button.disabled = true;
        button.textContent = 'Applying...';
        
        fetch('/cart/coupon/apply', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ coupon_code: couponCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Coupon applied successfully!', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showMessage(data.message, 'error');
                button.disabled = false;
                button.textContent = 'Apply';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while applying the coupon.', 'error');
            button.disabled = false;
            button.textContent = 'Apply';
        });
    }

    function removeCoupon(couponId) {
        fetch(`/cart/coupon/remove/${couponId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Coupon removed', 'success');
                setTimeout(() => location.reload(), 1000);
            } else {
                showMessage(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('An error occurred while removing the coupon.', 'error');
        });
    }

    function updateCartSummary(cart) {
        document.getElementById('cart-subtotal').textContent = `$${cart.subtotal.toFixed(2)}`;
        if (document.getElementById('cart-discount')) {
            document.getElementById('cart-discount').textContent = `-$${cart.discount.toFixed(2)}`;
        }
        
        const shipping = cart.subtotal >= 50 ? 0 : 9.99;
        const tax = cart.total * 0.08;
        const total = cart.total + shipping + tax;
        
        document.getElementById('cart-total').textContent = `$${total.toFixed(2)}`;
    }

    function showMessage(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-50 p-4 rounded-xl shadow-2xl transition-all duration-300 transform translate-x-0 ${
            type === 'success' 
                ? 'bg-gradient-to-r from-green-500 to-green-600 text-white' 
                : 'bg-gradient-to-r from-red-500 to-red-600 text-white'
        }`;
        toast.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    ${type === 'success' 
                        ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
                        : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
                    }
                </svg>
                <span class="font-semibold">${message}</span>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.style.transform = 'translateX(0)';
        }, 10);
        
        // Remove after 3 seconds
        setTimeout(() => {
            toast.style.transform = 'translateX(400px)';
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }
});
</script>
@endpush
@endsection
