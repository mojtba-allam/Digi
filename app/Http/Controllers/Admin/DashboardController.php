<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Modules\Authorization\app\Models\User;
use Modules\Product\app\Models\Product;
use Modules\Order\app\Models\Order;
use Modules\Business\app\Models\Vendor;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index(): View
    {
        // Get dashboard statistics
        $stats = $this->getDashboardStats();
        
        // Get recent orders
        $recentOrders = Order::with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get top products
        $topProducts = $this->getTopProducts();
        
        // Get sales chart data
        $salesData = $this->getSalesChartData();
        
        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'topProducts',
            'salesData',
            'recentUsers'
        ));
    }

    /**
     * Get dashboard statistics
     */
    private function getDashboardStats(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        $lastMonthEnd = Carbon::now()->subMonth()->endOfMonth();

        // Total revenue
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $thisMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', $thisMonth)
            ->sum('total_amount');
        $lastMonthRevenue = Order::where('status', '!=', 'cancelled')
            ->whereBetween('created_at', [$lastMonth, $lastMonthEnd])
            ->sum('total_amount');

        // Calculate revenue growth
        $revenueGrowth = $lastMonthRevenue > 0 
            ? (($thisMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 
            : 0;

        // Total orders
        $totalOrders = Order::count();
        $thisMonthOrders = Order::where('created_at', '>=', $thisMonth)->count();
        $lastMonthOrders = Order::whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        // Calculate orders growth
        $ordersGrowth = $lastMonthOrders > 0 
            ? (($thisMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 
            : 0;

        // Total customers
        $totalCustomers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->count();
        $thisMonthCustomers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->where('created_at', '>=', $thisMonth)->count();
        $lastMonthCustomers = User::whereHas('roles', function($query) {
            $query->where('name', 'customer');
        })->whereBetween('created_at', [$lastMonth, $lastMonthEnd])->count();

        // Calculate customers growth
        $customersGrowth = $lastMonthCustomers > 0 
            ? (($thisMonthCustomers - $lastMonthCustomers) / $lastMonthCustomers) * 100 
            : 0;

        // Total products
        $totalProducts = Product::where('status', 'active')->count();
        $lowStockProducts = Product::where('status', 'active')
            ->where('stock_quantity', '<=', 10)
            ->count();

        return [
            'total_revenue' => $totalRevenue,
            'revenue_growth' => round($revenueGrowth, 1),
            'total_orders' => $totalOrders,
            'orders_growth' => round($ordersGrowth, 1),
            'total_customers' => $totalCustomers,
            'customers_growth' => round($customersGrowth, 1),
            'total_products' => $totalProducts,
            'low_stock_products' => $lowStockProducts,
            'total_vendors' => Vendor::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];
    }

    /**
     * Get top selling products
     */
    private function getTopProducts(): array
    {
        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'products.name',
                'products.price',
                DB::raw('SUM(order_items.quantity) as total_sold'),
                DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->groupBy('products.id', 'products.name', 'products.price')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get()
            ->toArray();
    }

    /**
     * Get sales chart data for the last 30 days
     */
    private function getSalesChartData(): array
    {
        $days = [];
        $sales = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $days[] = $date->format('M j');
            
            $dailySales = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            
            $sales[] = (float) $dailySales;
        }

        return [
            'labels' => $days,
            'data' => $sales,
        ];
    }
}