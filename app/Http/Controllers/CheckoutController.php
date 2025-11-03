<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Cart\app\Models\Cart;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderItem;
use Modules\Payment\app\Models\Payment;
use Modules\User\app\Models\Address;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     */
    public function index(): View|RedirectResponse
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Load cart relationships
        $cart->load(['items.product.product_media', 'items.productVariant', 'coupons']);

        // Get user addresses if authenticated
        $addresses = [];
        if (Auth::check()) {
            $addresses = Address::where('user_id', Auth::id())->get();
        }

        return view('checkout.index', compact('cart', 'addresses'));
    }

    /**
     * Process the checkout
     */
    public function process(Request $request): RedirectResponse
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Validate checkout data
        $validated = $request->validate([
            'email' => 'required|email',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'payment_method' => 'required|in:credit_card,paypal,stripe',
            'save_address' => 'nullable|boolean',
            // Payment fields
            'card_number' => 'required_if:payment_method,credit_card|string',
            'card_expiry' => 'required_if:payment_method,credit_card|string',
            'card_cvc' => 'required_if:payment_method,credit_card|string',
            'card_name' => 'required_if:payment_method,credit_card|string',
        ]);

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $cart->subtotal;
            $discount = $cart->discount;
            $shipping = $subtotal >= 50 ? 0 : 9.99;
            $tax = $subtotal * 0.08; // 8% tax
            $total = $subtotal - $discount + $shipping + $tax;

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => $shipping,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'currency' => 'USD',
                'billing_address' => json_encode([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'address_line_1' => $validated['address_line_1'],
                    'address_line_2' => $validated['address_line_2'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'postal_code' => $validated['postal_code'],
                    'country' => $validated['country'],
                ]),
                'shipping_address' => json_encode([
                    'first_name' => $validated['first_name'],
                    'last_name' => $validated['last_name'],
                    'address_line_1' => $validated['address_line_1'],
                    'address_line_2' => $validated['address_line_2'],
                    'city' => $validated['city'],
                    'state' => $validated['state'],
                    'postal_code' => $validated['postal_code'],
                    'country' => $validated['country'],
                ]),
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                    'product_name' => $item->product->name,
                    'product_sku' => $item->product->sku,
                    'product_options' => $item->options,
                ]);
            }

            // Process payment
            $paymentResult = $this->processPayment($order, $validated);
            
            if (!$paymentResult['success']) {
                DB::rollBack();
                return back()->withErrors(['payment' => $paymentResult['message']])->withInput();
            }

            // Create payment record
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'currency' => 'USD',
                'status' => 'completed',
                'transaction_id' => $paymentResult['transaction_id'],
                'gateway_response' => json_encode($paymentResult['gateway_data'] ?? []),
            ]);

            // Update order status
            $order->update(['status' => 'confirmed']);

            // Save address if requested and user is authenticated
            if ($validated['save_address'] && Auth::check()) {
                $this->saveUserAddress($validated);
            }

            // Clear cart
            $cart->clear();

            DB::commit();

            return redirect()->route('checkout.success', $order->id)
                           ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withErrors(['general' => 'An error occurred while processing your order. Please try again.'])
                        ->withInput();
        }
    }

    /**
     * Show order success page
     */
    public function success(int $orderId): View
    {
        $order = Order::with(['items.product', 'payment'])->findOrFail($orderId);
        
        // Ensure user can only see their own orders
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }

    /**
     * Get guest checkout form
     */
    public function guest(): View
    {
        $cart = $this->getCart();
        
        if (!$cart || $cart->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cart->load(['items.product.product_media', 'items.productVariant', 'coupons']);

        return view('checkout.guest', compact('cart'));
    }

    /**
     * Process guest checkout
     */
    public function processGuest(Request $request): RedirectResponse
    {
        // Similar to process() but for guest users
        return $this->process($request);
    }

    /**
     * Get the current cart
     */
    private function getCart(): ?Cart
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        }

        $sessionId = session()->getId();
        return Cart::where('session_id', $sessionId)->where('user_id', null)->first();
    }

    /**
     * Generate a unique order number
     */
    private function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . strtoupper(uniqid());
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Process payment (mock implementation)
     */
    private function processPayment(Order $order, array $paymentData): array
    {
        // This is a mock payment processor
        // In a real application, you would integrate with actual payment gateways
        
        $paymentMethod = $paymentData['payment_method'];
        
        switch ($paymentMethod) {
            case 'credit_card':
                return $this->processCreditCardPayment($order, $paymentData);
            case 'paypal':
                return $this->processPayPalPayment($order, $paymentData);
            case 'stripe':
                return $this->processStripePayment($order, $paymentData);
            default:
                return [
                    'success' => false,
                    'message' => 'Invalid payment method'
                ];
        }
    }

    /**
     * Process credit card payment (mock)
     */
    private function processCreditCardPayment(Order $order, array $paymentData): array
    {
        // Mock credit card processing
        // In reality, you would use a payment gateway like Stripe, Square, etc.
        
        $cardNumber = $paymentData['card_number'];
        
        // Simple validation (in reality, use proper card validation)
        if (strlen(str_replace(' ', '', $cardNumber)) < 13) {
            return [
                'success' => false,
                'message' => 'Invalid card number'
            ];
        }

        // Simulate payment processing
        sleep(1); // Simulate processing time
        
        // Mock success (90% success rate)
        if (rand(1, 10) <= 9) {
            return [
                'success' => true,
                'transaction_id' => 'TXN_' . uniqid(),
                'gateway_data' => [
                    'card_last_four' => substr(str_replace(' ', '', $cardNumber), -4),
                    'card_type' => 'visa', // Mock card type
                    'authorization_code' => strtoupper(uniqid()),
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Payment declined. Please try a different card.'
            ];
        }
    }

    /**
     * Process PayPal payment (mock)
     */
    private function processPayPalPayment(Order $order, array $paymentData): array
    {
        // Mock PayPal processing
        return [
            'success' => true,
            'transaction_id' => 'PP_' . uniqid(),
            'gateway_data' => [
                'paypal_transaction_id' => uniqid(),
                'payer_email' => $paymentData['email'],
            ]
        ];
    }

    /**
     * Process Stripe payment (mock)
     */
    private function processStripePayment(Order $order, array $paymentData): array
    {
        // Mock Stripe processing
        return [
            'success' => true,
            'transaction_id' => 'STRIPE_' . uniqid(),
            'gateway_data' => [
                'stripe_charge_id' => 'ch_' . uniqid(),
                'stripe_customer_id' => 'cus_' . uniqid(),
            ]
        ];
    }

    /**
     * Save user address
     */
    private function saveUserAddress(array $addressData): void
    {
        if (!Auth::check()) {
            return;
        }

        Address::create([
            'user_id' => Auth::id(),
            'type' => 'billing',
            'first_name' => $addressData['first_name'],
            'last_name' => $addressData['last_name'],
            'address_line_1' => $addressData['address_line_1'],
            'address_line_2' => $addressData['address_line_2'],
            'city' => $addressData['city'],
            'state' => $addressData['state'],
            'postal_code' => $addressData['postal_code'],
            'country' => $addressData['country'],
            'is_default' => false,
        ]);
    }
}