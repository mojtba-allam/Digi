<?php

namespace Modules\Admin\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Modules\Authorization\app\Models\User;
use Modules\Product\app\Models\Product;
use Modules\Order\app\Models\Order;
use Modules\Business\app\Models\Vendor;
use Modules\AnalyticsAndReporting\app\Models\Analytic;
use Modules\AnalyticsAndReporting\app\Models\Report;
use Carbon\Carbon;

class AnalyticsApiController extends Controller
{
    /**
     * Get dashboard overview statistics.
     */
    public function overview(Request $request): JsonResponse
    {
        $period = $request->get('period', '30'); // days
        $startDate = Carbon::now()->subDays($period);

        $stats = [
            'total_revenue' => $this->getTotalRevenue($startDate),
            'revenue_growth' => $this->getRevenueGrowth($period),
            'total_orders' => $this->getTotalOrders($startDate),
            'orders_growth' => $this->getOrdersGrowth($period),
            'total_customers' => $this->getTotalCustomers($startDate),
            'customers_growth' => $this->getCustomersGrowth($period),
            'total_products' => Product::count(),
            'products_growth' => $this->getProductsGrowth($period),
            'conversion_rate' => $this->getConversionRate($startDate),
            'average_order_value' => $this->getAverageOrderValue($startDate),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get sales analytics.
     */
    public function sales(Request $request): JsonResponse
    {
        $period = $request->get('period', '30');
        $groupBy = $request->get('group_by', 'day'); // day, week, month
        $startDate = Carbon::now()->subDays($period);

        $salesData = $this->getSalesData($startDate, $groupBy);
        $topProducts = $this->getTopSellingProducts($startDate, 10);
        $salesByCategory = $this->getSalesByCategory($startDate);
        $salesByVendor = $this->getSalesByVendor($startDate);

        return response()->json([
            'success' => true,
            'data' => [
                'sales_chart' => $salesData,
                'top_products' => $topProducts,
                'sales_by_category' => $salesByCategory,
                'sales_by_vendor' => $salesByVendor,
            ]
        ]);
    }

    /**
     * Get customer analytics.
     */
    public function customers(Request $request): JsonResponse
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);

        $customerData = [
            'new_customers' => $this->getNewCustomersData($startDate),
            'customer_retention' => $this->getCustomerRetention($startDate),
            'customer_lifetime_value' => $this->getCustomerLifetimeValue(),
            'customers_by_location' => $this->getCustomersByLocation(),
            'top_customers' => $this->getTopCustomers($startDate, 10),
        ];

        return response()->json([
            'success' => true,
            'data' => $customerData
        ]);
    }

    /**
     * Get product analytics.
     */
    public function products(Request $request): JsonResponse
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);

        $productData = [
            'inventory_status' => $this->getInventoryStatus(),
            'product_performance' => $this->getProductPerformance($startDate),
            'category_performance' => $this->getCategoryPerformance($startDate),
            'low_stock_alerts' => $this->getLowStockAlerts(),
            'product_reviews' => $this->getProductReviewsAnalytics($startDate),
        ];

        return response()->json([
            'success' => true,
            'data' => $productData
        ]);
    }

    /**
     * Get vendor analytics.
     */
    public function vendors(Request $request): JsonResponse
    {
        $period = $request->get('period', '30');
        $startDate = Carbon::now()->subDays($period);

        $vendorData = [
            'vendor_performance' => $this->getVendorPerformance($startDate),
            'commission_summary' => $this->getCommissionSummary($startDate),
            'top_vendors' => $this->getTopVendors($startDate, 10),
            'vendor_growth' => $this->getVendorGrowth($startDate),
        ];

        return response()->json([
            'success' => true,
            'data' => $vendorData
        ]);
    }

    /**
     * Generate and export reports.
     */
    public function generateReport(Request $request): JsonResponse
    {
        $request->validate([
            'type' => ['required', 'in:sales,customers,products,vendors,financial'],
            'period' => ['required', 'integer', 'min:1', 'max:365'],
            'format' => ['required', 'in:json,csv,pdf'],
        ]);

        $reportData = $this->generateReportData($request->type, $request->period);
        
        $report = Report::create([
            'name' => ucfirst($request->type) . ' Report - ' . now()->format('Y-m-d'),
            'type' => $request->type,
            'body' => json_encode($reportData),
            'exported_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'report_id' => $report->id,
                'download_url' => route('admin.api.analytics.download-report', $report->id),
                'data' => $reportData
            ],
            'message' => 'Report generated successfully.'
        ]);
    }

    /**
     * Get available reports.
     */
    public function reports(): JsonResponse
    {
        $reports = Report::orderBy('exported_at', 'desc')->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $reports->items(),
            'meta' => [
                'current_page' => $reports->currentPage(),
                'last_page' => $reports->lastPage(),
                'per_page' => $reports->perPage(),
                'total' => $reports->total(),
            ]
        ]);
    }

    /**
     * Download a specific report.
     */
    public function downloadReport(Report $report): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'report' => $report,
                'content' => json_decode($report->body, true)
            ]
        ]);
    }

    // Private helper methods

    private function getTotalRevenue($startDate)
    {
        return Order::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->sum('total');
    }

    private function getRevenueGrowth($period)
    {
        $currentPeriod = Order::where('created_at', '>=', Carbon::now()->subDays($period))
            ->where('status', 'completed')
            ->sum('total');
        
        $previousPeriod = Order::where('created_at', '>=', Carbon::now()->subDays($period * 2))
            ->where('created_at', '<', Carbon::now()->subDays($period))
            ->where('status', 'completed')
            ->sum('total');

        if ($previousPeriod == 0) return 0;
        return (($currentPeriod - $previousPeriod) / $previousPeriod) * 100;
    }

    private function getTotalOrders($startDate)
    {
        return Order::where('created_at', '>=', $startDate)->count();
    }

    private function getOrdersGrowth($period)
    {
        $currentPeriod = Order::where('created_at', '>=', Carbon::now()->subDays($period))->count();
        $previousPeriod = Order::where('created_at', '>=', Carbon::now()->subDays($period * 2))
            ->where('created_at', '<', Carbon::now()->subDays($period))
            ->count();

        if ($previousPeriod == 0) return 0;
        return (($currentPeriod - $previousPeriod) / $previousPeriod) * 100;
    }

    private function getTotalCustomers($startDate)
    {
        return User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->where('created_at', '>=', $startDate)->count();
    }

    private function getCustomersGrowth($period)
    {
        $currentPeriod = User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->where('created_at', '>=', Carbon::now()->subDays($period))->count();
        
        $previousPeriod = User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->where('created_at', '>=', Carbon::now()->subDays($period * 2))
            ->where('created_at', '<', Carbon::now()->subDays($period))
            ->count();

        if ($previousPeriod == 0) return 0;
        return (($currentPeriod - $previousPeriod) / $previousPeriod) * 100;
    }

    private function getProductsGrowth($period)
    {
        $currentPeriod = Product::where('created_at', '>=', Carbon::now()->subDays($period))->count();
        $previousPeriod = Product::where('created_at', '>=', Carbon::now()->subDays($period * 2))
            ->where('created_at', '<', Carbon::now()->subDays($period))
            ->count();

        if ($previousPeriod == 0) return 0;
        return (($currentPeriod - $previousPeriod) / $previousPeriod) * 100;
    }

    private function getConversionRate($startDate)
    {
        $visitors = 1000; // This would come from analytics tracking
        $orders = Order::where('created_at', '>=', $startDate)->count();
        
        return $visitors > 0 ? ($orders / $visitors) * 100 : 0;
    }

    private function getAverageOrderValue($startDate)
    {
        return Order::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->avg('total') ?? 0;
    }

    private function getSalesData($startDate, $groupBy)
    {
        $format = match($groupBy) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m-%d'
        };

        return Order::where('created_at', '>=', $startDate)
            ->where('status', 'completed')
            ->selectRaw("DATE_FORMAT(created_at, '{$format}') as period, SUM(total) as revenue, COUNT(*) as orders")
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }

    private function getTopSellingProducts($startDate, $limit)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'completed')
            ->selectRaw('products.name, SUM(order_items.quantity) as total_sold, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getSalesByCategory($startDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->join('categories', 'category_product.category_id', '=', 'categories.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'completed')
            ->selectRaw('categories.name as category, SUM(order_items.price * order_items.quantity) as revenue')
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();
    }

    private function getSalesByVendor($startDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('vendors', 'products.vendor_id', '=', 'vendors.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'completed')
            ->selectRaw('vendors.name as vendor, SUM(order_items.price * order_items.quantity) as revenue, COUNT(DISTINCT orders.id) as orders')
            ->groupBy('vendors.id', 'vendors.name')
            ->orderBy('revenue', 'desc')
            ->get();
    }

    private function getNewCustomersData($startDate)
    {
        return User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function getCustomerRetention($startDate)
    {
        // Simplified retention calculation
        $totalCustomers = User::whereHas('roles', function($q) {
            $q->where('name', 'customer');
        })->count();
        
        $returningCustomers = User::whereHas('orders', function($q) use ($startDate) {
            $q->where('created_at', '>=', $startDate);
        })->whereHas('orders', function($q) use ($startDate) {
            $q->where('created_at', '<', $startDate);
        })->count();

        return $totalCustomers > 0 ? ($returningCustomers / $totalCustomers) * 100 : 0;
    }

    private function getCustomerLifetimeValue()
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.status', 'completed')
            ->selectRaw('AVG(user_totals.total) as avg_clv')
            ->fromSub(function($query) {
                $query->from('orders')
                    ->selectRaw('user_id, SUM(total) as total')
                    ->where('status', 'completed')
                    ->groupBy('user_id');
            }, 'user_totals')
            ->value('avg_clv') ?? 0;
    }

    private function getCustomersByLocation()
    {
        return DB::table('users')
            ->join('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.user_id')
            ->leftJoin('addresses', 'users.id', '=', 'addresses.user_id')
            ->leftJoin('cities', 'addresses.city_id', '=', 'cities.id')
            ->leftJoin('countries', 'cities.country_id', '=', 'countries.id')
            ->where('roles.name', 'customer')
            ->selectRaw('COALESCE(countries.name, "Unknown") as country, COUNT(*) as count')
            ->groupBy('countries.name')
            ->orderBy('count', 'desc')
            ->get();
    }

    private function getTopCustomers($startDate, $limit)
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->where('orders.created_at', '>=', $startDate)
            ->where('orders.status', 'completed')
            ->selectRaw('users.name, users.email, SUM(orders.total) as total_spent, COUNT(*) as order_count')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getInventoryStatus()
    {
        return [
            'in_stock' => Product::where('stock', '>', 10)->count(),
            'low_stock' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'out_of_stock' => Product::where('stock', '<=', 0)->count(),
            'total_value' => Product::selectRaw('SUM(price * stock)')->value('SUM(price * stock)') ?? 0,
        ];
    }

    private function getProductPerformance($startDate)
    {
        return DB::table('products')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.id')
            ->where(function($query) use ($startDate) {
                $query->whereNull('orders.created_at')
                    ->orWhere('orders.created_at', '>=', $startDate);
            })
            ->where(function($query) {
                $query->whereNull('orders.status')
                    ->orWhere('orders.status', 'completed');
            })
            ->selectRaw('products.name, COALESCE(SUM(order_items.quantity), 0) as units_sold, COALESCE(SUM(order_items.price * order_items.quantity), 0) as revenue')
            ->groupBy('products.id', 'products.name')
            ->orderBy('revenue', 'desc')
            ->limit(20)
            ->get();
    }

    private function getCategoryPerformance($startDate)
    {
        return $this->getSalesByCategory($startDate);
    }

    private function getLowStockAlerts()
    {
        return Product::with('vendor')
            ->where('stock', '>', 0)
            ->where('stock', '<=', 10)
            ->orderBy('stock')
            ->get()
            ->map(function($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'stock' => $product->stock,
                    'vendor' => $product->vendor->name ?? 'Unknown',
                ];
            });
    }

    private function getProductReviewsAnalytics($startDate)
    {
        return DB::table('reviews')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->where('reviews.created_at', '>=', $startDate)
            ->selectRaw('AVG(reviews.rating) as average_rating, COUNT(*) as total_reviews')
            ->first();
    }

    private function getVendorPerformance($startDate)
    {
        return $this->getSalesByVendor($startDate);
    }

    private function getCommissionSummary($startDate)
    {
        // This would integrate with the CommissionAndPayout module
        return [
            'total_commissions' => 0,
            'pending_payouts' => 0,
            'completed_payouts' => 0,
        ];
    }

    private function getTopVendors($startDate, $limit)
    {
        return $this->getSalesByVendor($startDate)->take($limit);
    }

    private function getVendorGrowth($startDate)
    {
        return Vendor::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    private function generateReportData($type, $period)
    {
        $startDate = Carbon::now()->subDays($period);
        
        return match($type) {
            'sales' => [
                'overview' => $this->getTotalRevenue($startDate),
                'chart_data' => $this->getSalesData($startDate, 'day'),
                'top_products' => $this->getTopSellingProducts($startDate, 20),
            ],
            'customers' => [
                'new_customers' => $this->getNewCustomersData($startDate),
                'top_customers' => $this->getTopCustomers($startDate, 20),
                'retention_rate' => $this->getCustomerRetention($startDate),
            ],
            'products' => [
                'performance' => $this->getProductPerformance($startDate),
                'inventory' => $this->getInventoryStatus(),
                'low_stock' => $this->getLowStockAlerts(),
            ],
            'vendors' => [
                'performance' => $this->getVendorPerformance($startDate),
                'growth' => $this->getVendorGrowth($startDate),
            ],
            default => []
        };
    }
}