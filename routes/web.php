<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $featuredProducts = \Modules\Product\app\Models\Product::where('status', 'active')
        ->with(['brands', 'categories'])
        ->inRandomOrder()
        ->limit(8)
        ->get();
    
    return view('home', compact('featuredProducts'));
})->name('home');

// Authentication routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.post');

Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

// Password Reset routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLink'])->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');

// Product routes
Route::get('/products', [App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
Route::get('/api/products/search', [App\Http\Controllers\ProductController::class, 'search'])->name('products.search');
Route::get('/api/products/suggestions', [App\Http\Controllers\ProductController::class, 'suggestions'])->name('products.suggestions');

// Category routes
Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::get('/api/categories/{id}/subcategories', [App\Http\Controllers\CategoryController::class, 'subcategories'])->name('categories.subcategories');

// Vendor routes
Route::get('/vendors', [App\Http\Controllers\VendorController::class, 'index'])->name('vendors.index');
Route::get('/vendors/{id}', [App\Http\Controllers\VendorController::class, 'show'])->name('vendors.show');

// Static pages routes
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/help-center', function () {
    return view('pages.help-center');
})->name('help-center');

Route::get('/shipping-info', function () {
    return view('pages.shipping-info');
})->name('shipping-info');

Route::get('/returns', function () {
    return view('pages.returns');
})->name('returns');

Route::get('/track-order', function () {
    return view('pages.track-order');
})->name('track-order');

Route::get('/faq', function () {
    return view('pages.faq');
})->name('faq');

Route::get('/privacy-policy', function () {
    return view('pages.privacy-policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('pages.terms-of-service');
})->name('terms-of-service');

Route::get('/cookie-policy', function () {
    return view('pages.cookie-policy');
})->name('cookie-policy');

// Cart routes
Route::get('/cart', [Modules\Cart\app\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [Modules\Cart\app\Http\Controllers\CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{itemId}', [Modules\Cart\app\Http\Controllers\CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{itemId}', [Modules\Cart\app\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [Modules\Cart\app\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/coupon/apply', [Modules\Cart\app\Http\Controllers\CartController::class, 'applyCoupon'])->name('cart.coupon.apply');
Route::delete('/cart/coupon/remove/{couponId}', [Modules\Cart\app\Http\Controllers\CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::get('/api/cart/count', [Modules\Cart\app\Http\Controllers\CartController::class, 'count'])->name('cart.count');

// Checkout routes
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderId}', [App\Http\Controllers\CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/checkout/guest', [App\Http\Controllers\CheckoutController::class, 'guest'])->name('checkout.guest');
Route::post('/checkout/guest/process', [App\Http\Controllers\CheckoutController::class, 'processGuest'])->name('checkout.guest.process');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return view('profile.show');
    })->name('profile.show');
    
    Route::get('/orders', function () {
        return view('orders.index');
    })->name('orders.index');
    
    Route::get('/wishlist', function () {
        return view('wishlist.index');
    })->name('wishlist.index');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    Route::get('/users/create', function () {
        return view('admin.users.create');
    })->name('users.create');
    
    Route::get('/products', function () {
        return view('admin.products.index');
    })->name('products.index');
    
    Route::get('/products/create', function () {
        return view('admin.products.create');
    })->name('products.create');
    
    Route::get('/orders', function () {
        return view('admin.orders.index');
    })->name('orders.index');
    
    Route::get('/vendors', function () {
        return view('admin.vendors.index');
    })->name('vendors.index');
    
    Route::get('/analytics', function () {
        return view('admin.analytics.index');
    })->name('analytics.index');
    
    Route::get('/settings', function () {
        return view('admin.settings.index');
    })->name('settings.index');
    
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');
    
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');
    
    Route::get('/brands', function () {
        return view('admin.brands.index');
    })->name('brands.index');
});

// Vendor routes
Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    Route::get('/dashboard', function () {
        return view('vendor.dashboard');
    })->name('dashboard');
    
    Route::get('/products', function () {
        return view('vendor.products.index');
    })->name('products.index');
    
    Route::get('/products/create', function () {
        return view('vendor.products.create');
    })->name('products.create');
    
    Route::get('/orders', function () {
        return view('vendor.orders.index');
    })->name('orders.index');
    
    Route::get('/commission', function () {
        return view('vendor.commission.index');
    })->name('commission.index');
    
    Route::get('/payouts', function () {
        return view('vendor.payouts.index');
    })->name('payouts.index');
    
    Route::get('/analytics', function () {
        return view('vendor.analytics.index');
    })->name('analytics.index');
    
    Route::get('/profile', function () {
        return view('vendor.profile.show');
    })->name('profile.show');
    
    Route::get('/settings', function () {
        return view('vendor.settings.index');
    })->name('settings.index');
    
    Route::get('/inventory', function () {
        return view('vendor.inventory.index');
    })->name('inventory.index');
});
