<?php

namespace Modules\Cart\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Modules\Cart\app\Models\Cart;
use Modules\Cart\app\Models\CartItem;
use Modules\Product\app\Models\Product;
use Modules\PromotionAndCoupon\app\Models\Coupon;

class CartController extends Controller
{
    /**
     * Display the cart page.
     */
    public function index(): View
    {
        $cart = $this->getOrCreateCart();
        $cart->load(['items.product.product_media', 'items.productVariant', 'coupons']);
        
        return view('cart.index', compact('cart'));
    }

    /**
     * Add item to cart.
     */
    public function add(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'options' => 'sometimes|array',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Check if product is available
        if ($product->status !== 'active') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is not available.'
                ], 400);
            }
            return back()->with('error', 'Product is not available.');
        }

        $cart = $this->getOrCreateCart();
        
        try {
            $cartItem = $cart->addItem(
                $product,
                $request->quantity,
                $request->options ?? [],
                $request->product_variant_id
            );

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Product added to cart successfully.',
                    'cart_count' => $cart->total_items,
                    'item' => [
                        'id' => $cartItem->id,
                        'name' => $cartItem->display_name,
                        'quantity' => $cartItem->quantity,
                        'price' => $cartItem->price,
                        'total' => $cartItem->total,
                    ]
                ]);
            }

            return back()->with('success', 'Product added to cart successfully.');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to add product to cart.'
                ], 500);
            }
            return back()->with('error', 'Failed to add product to cart.');
        }
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, int $itemId): JsonResponse|RedirectResponse
    {
        $request->validate([
            'quantity' => 'required|integer|min:0|max:99',
        ]);

        $cart = $this->getOrCreateCart();
        
        if ($cart->updateItem($itemId, $request->quantity)) {
            $cart->refresh();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart updated successfully.',
                    'cart' => [
                        'total_items' => $cart->total_items,
                        'subtotal' => $cart->subtotal,
                        'discount' => $cart->discount,
                        'total' => $cart->total,
                    ]
                ]);
            }

            return back()->with('success', 'Cart updated successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart item.'
            ], 400);
        }

        return back()->with('error', 'Failed to update cart item.');
    }

    /**
     * Remove item from cart.
     */
    public function remove(Request $request, int $itemId): JsonResponse|RedirectResponse
    {
        $cart = $this->getOrCreateCart();
        
        if ($cart->removeItem($itemId)) {
            $cart->refresh();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart.',
                    'cart' => [
                        'total_items' => $cart->total_items,
                        'subtotal' => $cart->subtotal,
                        'discount' => $cart->discount,
                        'total' => $cart->total,
                    ]
                ]);
            }

            return back()->with('success', 'Item removed from cart.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item from cart.'
            ], 400);
        }

        return back()->with('error', 'Failed to remove item from cart.');
    }

    /**
     * Clear all items from cart.
     */
    public function clear(Request $request): JsonResponse|RedirectResponse
    {
        $cart = $this->getOrCreateCart();
        
        if ($cart->clear()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cart cleared successfully.',
                    'cart' => [
                        'total_items' => 0,
                        'subtotal' => 0,
                        'discount' => 0,
                        'total' => 0,
                    ]
                ]);
            }

            return back()->with('success', 'Cart cleared successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart.'
            ], 500);
        }

        return back()->with('error', 'Failed to clear cart.');
    }

    /**
     * Apply coupon to cart.
     */
    public function applyCoupon(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'coupon_code' => 'required|string|max:50',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)
                        ->where('status', 'active')
                        ->where('starts_at', '<=', now())
                        ->where('expires_at', '>=', now())
                        ->first();

        if (!$coupon) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid or expired coupon code.'
                ], 400);
            }
            return back()->with('error', 'Invalid or expired coupon code.');
        }

        $cart = $this->getOrCreateCart();

        // Check minimum order amount if applicable
        if ($coupon->minimum_amount && $cart->subtotal < $coupon->minimum_amount) {
            $message = "Minimum order amount of $" . number_format($coupon->minimum_amount, 2) . " required for this coupon.";
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ], 400);
            }
            return back()->with('error', $message);
        }

        if ($cart->applyCoupon($coupon)) {
            $cart->refresh();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon applied successfully.',
                    'cart' => [
                        'subtotal' => $cart->subtotal,
                        'discount' => $cart->discount,
                        'total' => $cart->total,
                    ]
                ]);
            }

            return back()->with('success', 'Coupon applied successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon is already applied or cannot be used.'
            ], 400);
        }

        return back()->with('error', 'Coupon is already applied or cannot be used.');
    }

    /**
     * Remove coupon from cart.
     */
    public function removeCoupon(Request $request, int $couponId): JsonResponse|RedirectResponse
    {
        $coupon = Coupon::findOrFail($couponId);
        $cart = $this->getOrCreateCart();

        if ($cart->removeCoupon($coupon)) {
            $cart->refresh();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Coupon removed successfully.',
                    'cart' => [
                        'subtotal' => $cart->subtotal,
                        'discount' => $cart->discount,
                        'total' => $cart->total,
                    ]
                ]);
            }

            return back()->with('success', 'Coupon removed successfully.');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove coupon.'
            ], 400);
        }

        return back()->with('error', 'Failed to remove coupon.');
    }

    /**
     * Get cart count for AJAX requests.
     */
    public function count(): JsonResponse
    {
        $cart = $this->getOrCreateCart();
        
        return response()->json([
            'count' => $cart->total_items
        ]);
    }

    /**
     * Get or create cart for the current user/session.
     */
    private function getOrCreateCart(): Cart
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['status' => 'active']
            );
        }

        // For guest users, use session-based cart
        $sessionId = session()->getId();
        return Cart::firstOrCreate(
            ['session_id' => $sessionId, 'user_id' => null],
            ['status' => 'active']
        );
    }
}