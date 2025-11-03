<?php

namespace Modules\Business\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderStatus;
use Modules\Business\app\Models\Vendor;
use Modules\Notification\app\Models\Notification;
use Modules\Business\App\Http\Requests\UpdateOrderStatusRequest;

class VendorOrderController extends Controller
{
    /**
     * Display a listing of vendor orders with filtering and pagination.
     */
    public function index(Request $request)
    {
        $vendor = $this->getAuthenticatedVendor();
        
        if (!$vendor) {
            return redirect()->route('login')->with('error', 'Vendor access required');
        }

        $query = Order::with(['user', 'items.product', 'orderStatuses' => function($q) {
            $q->latest();
        }])
        ->whereHas('items.product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        });

        // Status filtering
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filtering
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by order number or customer name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $orders = $query->paginate(20)->withQueryString();

        // Get order status counts for filter badges
        $statusCounts = [
            'all' => $this->getVendorOrderCount($vendor),
            'pending' => $this->getVendorOrderCount($vendor, 'pending'),
            'confirmed' => $this->getVendorOrderCount($vendor, 'confirmed'),
            'processing' => $this->getVendorOrderCount($vendor, 'processing'),
            'shipped' => $this->getVendorOrderCount($vendor, 'shipped'),
            'delivered' => $this->getVendorOrderCount($vendor, 'delivered'),
            'cancelled' => $this->getVendorOrderCount($vendor, 'cancelled'),
            'refunded' => $this->getVendorOrderCount($vendor, 'refunded'),
        ];

        return view('business::vendor.orders.index', compact('orders', 'statusCounts', 'vendor'));
    }

    /**
     * Display the specified order with detailed information.
     */
    public function show(Order $order)
    {
        $vendor = $this->getAuthenticatedVendor();
        
        if (!$vendor) {
            return redirect()->route('login')->with('error', 'Vendor access required');
        }

        // Check if vendor has access to this order
        $hasAccess = $order->items()->whereHas('product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->exists();

        if (!$hasAccess) {
            abort(403, 'Unauthorized access to this order');
        }

        $order->load([
            'user',
            'items' => function($q) use ($vendor) {
                $q->whereHas('product', function($productQuery) use ($vendor) {
                    $productQuery->where('vendor_id', $vendor->id);
                });
            },
            'items.product',
            'items.productVariant',
            'orderStatuses' => function($q) {
                $q->orderBy('created_at', 'desc');
            },
            'payment',
            'returnRequests'
        ]);

        // Get available status transitions for vendor
        $availableStatuses = $this->getVendorAvailableStatusTransitions($order->status);

        return view('business::vendor.orders.show', compact('order', 'availableStatuses', 'vendor'));
    }

    /**
     * Update the order status (vendor-specific actions).
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): JsonResponse
    {
        $vendor = $this->getAuthenticatedVendor();
        
        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor authentication required'
            ], 401);
        }

        // Check if vendor has access to this order
        $hasAccess = $order->items()->whereHas('product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->exists();

        if (!$hasAccess) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to this order'
            ], 403);
        }

        // Validation is handled by UpdateOrderStatusRequest

        $newStatus = $request->status;
        $notes = $request->notes;
        $trackingNumber = $request->tracking_number;

        // Validate status transition for vendor
        if (!$this->isValidVendorStatusTransition($order->status, $newStatus)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition'
            ], 400);
        }

        // Update order status
        $order->update(['status' => $newStatus]);

        // Create status history record
        $statusRecord = OrderStatus::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'notes' => $notes . ($trackingNumber ? " (Tracking: {$trackingNumber})" : ''),
            'created_at' => now()
        ]);

        // Update timestamps for specific statuses
        if ($newStatus === 'shipped' && !$order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        } elseif ($newStatus === 'delivered' && !$order->delivered_at) {
            $order->update(['delivered_at' => now()]);
        }

        // Send notification to customer
        $this->sendOrderStatusNotification($order, $newStatus, $vendor);

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $newStatus,
            'status_color' => $order->fresh()->status_color,
            'tracking_number' => $trackingNumber
        ]);
    }

    /**
     * Mark order items as ready for fulfillment.
     */
    public function markReadyForFulfillment(Request $request, Order $order): JsonResponse
    {
        $vendor = $this->getAuthenticatedVendor();
        
        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor authentication required'
            ], 401);
        }

        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:order_items,id',
            'notes' => 'nullable|string|max:500'
        ]);

        $itemIds = $request->item_ids;
        $notes = $request->notes ?? 'Items marked ready for fulfillment';

        // Verify vendor owns these items
        $vendorItems = $order->items()->whereIn('id', $itemIds)
            ->whereHas('product', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })->get();

        if ($vendorItems->count() !== count($itemIds)) {
            return response()->json([
                'success' => false,
                'message' => 'Some items do not belong to this vendor'
            ], 403);
        }

        // Update order status if all vendor items are ready
        $allVendorItems = $order->items()->whereHas('product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })->get();

        if ($vendorItems->count() === $allVendorItems->count() && $order->status === 'confirmed') {
            $order->update(['status' => 'processing']);
            
            OrderStatus::create([
                'order_id' => $order->id,
                'status' => 'processing',
                'notes' => $notes,
                'created_at' => now()
            ]);

            $this->sendOrderStatusNotification($order, 'processing', $vendor);
        }

        return response()->json([
            'success' => true,
            'message' => 'Items marked ready for fulfillment',
            'processed_items' => $vendorItems->count()
        ]);
    }

    /**
     * Get vendor order statistics.
     */
    public function getStats(): JsonResponse
    {
        $vendor = $this->getAuthenticatedVendor();
        
        if (!$vendor) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor authentication required'
            ], 401);
        }

        $stats = [
            'total_orders' => $this->getVendorOrderCount($vendor),
            'pending_orders' => $this->getVendorOrderCount($vendor, 'pending'),
            'processing_orders' => $this->getVendorOrderCount($vendor, 'processing'),
            'shipped_orders' => $this->getVendorOrderCount($vendor, 'shipped'),
            'delivered_orders' => $this->getVendorOrderCount($vendor, 'delivered'),
            'total_revenue' => $this->getVendorRevenue($vendor),
            'today_orders' => $this->getVendorTodayOrderCount($vendor),
            'today_revenue' => $this->getVendorTodayRevenue($vendor)
        ];

        return response()->json($stats);
    }

    /**
     * Get authenticated vendor.
     */
    private function getAuthenticatedVendor(): ?Vendor
    {
        $user = Auth::user();
        return $user ? $user->vendor : null;
    }

    /**
     * Get vendor order count by status.
     */
    private function getVendorOrderCount(Vendor $vendor, ?string $status = null): int
    {
        $query = Order::whereHas('items.product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        });

        if ($status) {
            $query->where('status', $status);
        }

        return $query->count();
    }

    /**
     * Get vendor revenue.
     */
    private function getVendorRevenue(Vendor $vendor): float
    {
        return Order::whereHas('items.product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->whereIn('status', ['delivered', 'shipped'])
        ->sum('total_amount');
    }

    /**
     * Get vendor today order count.
     */
    private function getVendorTodayOrderCount(Vendor $vendor): int
    {
        return Order::whereHas('items.product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->whereDate('created_at', today())
        ->count();
    }

    /**
     * Get vendor today revenue.
     */
    private function getVendorTodayRevenue(Vendor $vendor): float
    {
        return Order::whereHas('items.product', function($q) use ($vendor) {
            $q->where('vendor_id', $vendor->id);
        })
        ->whereDate('created_at', today())
        ->whereIn('status', ['delivered', 'shipped'])
        ->sum('total_amount');
    }

    /**
     * Get available status transitions for vendor.
     */
    private function getVendorAvailableStatusTransitions(string $currentStatus): array
    {
        $transitions = [
            'pending' => ['confirmed'],
            'confirmed' => ['processing'],
            'processing' => ['shipped'],
            'shipped' => ['delivered'],
            'delivered' => [],
            'cancelled' => [],
            'refunded' => []
        ];

        return $transitions[$currentStatus] ?? [];
    }

    /**
     * Check if status transition is valid for vendor.
     */
    private function isValidVendorStatusTransition(string $currentStatus, string $newStatus): bool
    {
        $availableStatuses = $this->getVendorAvailableStatusTransitions($currentStatus);
        return in_array($newStatus, $availableStatuses);
    }

    /**
     * Send order status notification to customer.
     */
    private function sendOrderStatusNotification(Order $order, string $status, Vendor $vendor): void
    {
        $messages = [
            'confirmed' => 'Your order has been confirmed by the vendor',
            'processing' => 'Your order is being processed',
            'shipped' => 'Your order has been shipped',
            'delivered' => 'Your order has been delivered'
        ];

        $message = $messages[$status] ?? 'Your order status has been updated';

        // Create notification record
        Notification::create([
            'user_id' => $order->user_id,
            'title' => 'Order Status Update',
            'body' => $message . " (Order #{$order->formatted_order_number})"
        ]);

        // TODO: Send email notification
        // TODO: Send push notification if implemented
    }
}