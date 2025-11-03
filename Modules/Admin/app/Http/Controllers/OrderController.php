<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderStatus;
use Modules\Authorization\app\Models\User;
use Modules\Business\app\Models\Vendor;
use Modules\Admin\App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of orders with filtering and pagination.
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product', 'orderStatuses' => function($q) {
            $q->latest();
        }]);

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
            'all' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
            'refunded' => Order::where('status', 'refunded')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'statusCounts'));
    }

    /**
     * Display the specified order with detailed information.
     */
    public function show(Order $order)
    {
        $order->load([
            'user',
            'items.product',
            'items.productVariant',
            'orderStatuses' => function($q) {
                $q->orderBy('created_at', 'desc');
            },
            'payment',
            'vendors',
            'returnRequests'
        ]);

        // Get available status transitions
        $availableStatuses = $this->getAvailableStatusTransitions($order->status);

        return view('admin.orders.show', compact('order', 'availableStatuses'));
    }

    /**
     * Update the order status.
     */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order): JsonResponse
    {

        $newStatus = $request->status;
        $notes = $request->notes;

        // Validate status transition
        if (!$this->isValidStatusTransition($order->status, $newStatus)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid status transition'
            ], 400);
        }

        // Update order status
        $order->update(['status' => $newStatus]);

        // Create status history record
        OrderStatus::create([
            'order_id' => $order->id,
            'status' => $newStatus,
            'notes' => $notes,
            'created_at' => now()
        ]);

        // Update timestamps for specific statuses
        if ($newStatus === 'shipped' && !$order->shipped_at) {
            $order->update(['shipped_at' => now()]);
        } elseif ($newStatus === 'delivered' && !$order->delivered_at) {
            $order->update(['delivered_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Order status updated successfully',
            'status' => $newStatus,
            'status_color' => $order->fresh()->status_color
        ]);
    }

    /**
     * Bulk update order statuses.
     */
    public function bulkUpdateStatus(Request $request): JsonResponse
    {
        $request->validate([
            'order_ids' => 'required|array',
            'order_ids.*' => 'exists:orders,id',
            'status' => 'required|string|in:pending,confirmed,processing,shipped,delivered,cancelled,refunded'
        ]);

        $orderIds = $request->order_ids;
        $newStatus = $request->status;
        $updatedCount = 0;

        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            
            if ($order && $this->isValidStatusTransition($order->status, $newStatus)) {
                $order->update(['status' => $newStatus]);
                
                OrderStatus::create([
                    'order_id' => $order->id,
                    'status' => $newStatus,
                    'notes' => 'Bulk status update',
                    'created_at' => now()
                ]);

                $updatedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "Successfully updated {$updatedCount} orders",
            'updated_count' => $updatedCount
        ]);
    }

    /**
     * Get order statistics for dashboard.
     */
    public function getStats(): JsonResponse
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::whereIn('status', ['confirmed', 'processing'])->count(),
            'shipped_orders' => Order::where('status', 'shipped')->count(),
            'delivered_orders' => Order::where('status', 'delivered')->count(),
            'total_revenue' => Order::whereIn('status', ['delivered', 'shipped'])->sum('total_amount'),
            'today_orders' => Order::whereDate('created_at', today())->count(),
            'today_revenue' => Order::whereDate('created_at', today())
                                   ->whereIn('status', ['delivered', 'shipped'])
                                   ->sum('total_amount')
        ];

        return response()->json($stats);
    }

    /**
     * Export orders to CSV.
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->get();

        $filename = 'orders_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'Order ID',
                'Order Number',
                'Customer Name',
                'Customer Email',
                'Status',
                'Items Count',
                'Subtotal',
                'Tax Amount',
                'Shipping Amount',
                'Total Amount',
                'Created At',
                'Updated At'
            ]);

            // CSV data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->formatted_order_number,
                    $order->user->name ?? 'N/A',
                    $order->user->email ?? 'N/A',
                    ucfirst($order->status),
                    $order->items->count(),
                    $order->subtotal,
                    $order->tax_amount,
                    $order->shipping_amount,
                    $order->total_amount,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get available status transitions for current status.
     */
    private function getAvailableStatusTransitions(string $currentStatus): array
    {
        $transitions = [
            'pending' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['shipped', 'cancelled'],
            'shipped' => ['delivered'],
            'delivered' => ['refunded'],
            'cancelled' => [],
            'refunded' => []
        ];

        return $transitions[$currentStatus] ?? [];
    }

    /**
     * Check if status transition is valid.
     */
    private function isValidStatusTransition(string $currentStatus, string $newStatus): bool
    {
        $availableStatuses = $this->getAvailableStatusTransitions($currentStatus);
        return in_array($newStatus, $availableStatuses) || $currentStatus === $newStatus;
    }
}