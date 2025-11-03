<?php

namespace Modules\Admin\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Product\app\Models\Product;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Models\Brand;
use Modules\Business\app\Models\Vendor;
use Modules\Admin\App\Http\Requests\Api\StoreProductRequest;
use Modules\Admin\App\Http\Requests\Api\UpdateProductRequest;

class ProductApiController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): JsonResponse
    {
        $query = Product::with(['vendor', 'categories', 'brands', 'product_media']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->get('category'));
            });
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->whereHas('brands', function ($q) use ($request) {
                $q->where('brands.id', $request->get('brand'));
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->get('status'));
        }

        // Vendor filter
        if ($request->filled('vendor')) {
            $query->where('vendor_id', $request->get('vendor'));
        }

        // Stock filter
        if ($request->filled('stock_status')) {
            switch ($request->get('stock_status')) {
                case 'in_stock':
                    $query->where('stock', '>', 0);
                    break;
                case 'low_stock':
                    $query->where('stock', '>', 0)->where('stock', '<=', 10);
                    break;
                case 'out_of_stock':
                    $query->where('stock', '<=', 0);
                    break;
            }
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->get('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->get('max_price'));
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'from' => $products->firstItem(),
                'to' => $products->lastItem(),
            ]
        ]);
    }

    /**
     * Store a newly created product.
     */
    public function store(StoreProductRequest $request): JsonResponse
    {

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'vendor_id' => $request->vendor_id,
        ]);

        // Attach categories and brands
        $product->categories()->sync($request->categories);
        if ($request->brands) {
            $product->brands()->sync($request->brands);
        }

        $product->load(['vendor', 'categories', 'brands']);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product created successfully.'
        ], 201);
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): JsonResponse
    {
        $product->load(['vendor', 'categories', 'brands', 'product_media', 'reviews', 'product_variants']);
        
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Update the specified product.
     */
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'vendor_id' => $request->vendor_id,
        ]);

        // Update categories and brands
        $product->categories()->sync($request->categories);
        $product->brands()->sync($request->brands ?? []);

        $product->load(['vendor', 'categories', 'brands']);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product updated successfully.'
        ]);
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): JsonResponse
    {
        // Check if product has orders
        if ($product->carts()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete product that is in customer carts.'
            ], 422);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully.'
        ]);
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product): JsonResponse
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => "Product status updated to {$newStatus}."
        ]);
    }

    /**
     * Bulk actions for products.
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete,update_stock'],
            'products' => ['required', 'array'],
            'products.*' => ['exists:products,id'],
            'stock_value' => ['required_if:action,update_stock', 'integer', 'min:0'],
        ]);

        $products = Product::whereIn('id', $request->products)->get();
        $processedCount = 0;

        switch ($request->action) {
            case 'activate':
                $products->each(function($product) use (&$processedCount) {
                    $product->update(['status' => 'active']);
                    $processedCount++;
                });
                $message = "Activated {$processedCount} products successfully.";
                break;
            case 'deactivate':
                $products->each(function($product) use (&$processedCount) {
                    $product->update(['status' => 'inactive']);
                    $processedCount++;
                });
                $message = "Deactivated {$processedCount} products successfully.";
                break;
            case 'update_stock':
                $products->each(function($product) use ($request, &$processedCount) {
                    $product->update(['stock' => $request->stock_value]);
                    $processedCount++;
                });
                $message = "Updated stock for {$processedCount} products successfully.";
                break;
            case 'delete':
                $products->each(function($product) use (&$processedCount) {
                    if (!$product->carts()->exists()) {
                        $product->delete();
                        $processedCount++;
                    }
                });
                $message = "Deleted {$processedCount} products successfully.";
                break;
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'processed_count' => $processedCount
        ]);
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product): JsonResponse
    {
        $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update(['stock' => $request->stock]);

        return response()->json([
            'success' => true,
            'data' => $product,
            'message' => 'Product stock updated successfully.'
        ]);
    }

    /**
     * Get product statistics.
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::where('status', 'active')->count(),
            'inactive_products' => Product::where('status', 'inactive')->count(),
            'draft_products' => Product::where('status', 'draft')->count(),
            'in_stock_products' => Product::where('stock', '>', 0)->count(),
            'out_of_stock_products' => Product::where('stock', '<=', 0)->count(),
            'low_stock_products' => Product::where('stock', '>', 0)->where('stock', '<=', 10)->count(),
            'total_inventory_value' => Product::selectRaw('SUM(price * stock) as total')->value('total') ?? 0,
            'average_product_price' => Product::avg('price') ?? 0,
            'products_by_category' => Product::join('category_product', 'products.id', '=', 'category_product.product_id')
                ->join('categories', 'category_product.category_id', '=', 'categories.id')
                ->selectRaw('categories.name as category, COUNT(*) as count')
                ->groupBy('categories.name')
                ->get(),
            'products_by_vendor' => Product::join('vendors', 'products.vendor_id', '=', 'vendors.id')
                ->selectRaw('vendors.name as vendor, COUNT(*) as count')
                ->groupBy('vendors.name')
                ->get(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Get filter options for products.
     */
    public function filterOptions(): JsonResponse
    {
        $options = [
            'categories' => Category::select('id', 'name')->get(),
            'brands' => Brand::select('id', 'name')->get(),
            'vendors' => Vendor::select('id', 'name')->get(),
            'statuses' => ['active', 'inactive', 'draft'],
            'stock_statuses' => ['in_stock', 'low_stock', 'out_of_stock'],
        ];

        return response()->json([
            'success' => true,
            'data' => $options
        ]);
    }
}