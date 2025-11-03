<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Product\app\Models\Product;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Models\Brand;
use Modules\Business\app\Models\Vendor;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request): View
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

        $products = $query->paginate(15)->withQueryString();
        
        // Get filter options
        $categories = Category::all();
        $brands = Brand::all();
        $vendors = Vendor::all();

        return view('admin.products.index', compact('products', 'categories', 'brands', 'vendors'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        $vendors = Vendor::all();
        
        return view('admin.products.create', compact('categories', 'brands', 'vendors'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive,draft'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'brands' => ['array'],
            'brands.*' => ['exists:brands,id'],
        ]);

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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load(['vendor', 'categories', 'brands', 'product_media', 'reviews', 'product_variants']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        $brands = Brand::all();
        $vendors = Vendor::all();
        $product->load(['categories', 'brands']);
        
        return view('admin.products.edit', compact('product', 'categories', 'brands', 'vendors'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive,draft'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'brands' => ['array'],
            'brands.*' => ['exists:brands,id'],
        ]);

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

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Check if product has orders
        if ($product->carts()->exists()) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product that is in customer carts.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product): RedirectResponse
    {
        $newStatus = $product->status === 'active' ? 'inactive' : 'active';
        $product->update(['status' => $newStatus]);

        return redirect()->route('admin.products.index')
            ->with('success', "Product status updated to {$newStatus}.");
    }

    /**
     * Bulk actions for products.
     */
    public function bulkAction(Request $request): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:activate,deactivate,delete,update_stock'],
            'products' => ['required', 'array'],
            'products.*' => ['exists:products,id'],
            'stock_value' => ['required_if:action,update_stock', 'integer', 'min:0'],
        ]);

        $products = Product::whereIn('id', $request->products)->get();

        switch ($request->action) {
            case 'activate':
                $products->each(fn($product) => $product->update(['status' => 'active']));
                $message = 'Products activated successfully.';
                break;
            case 'deactivate':
                $products->each(fn($product) => $product->update(['status' => 'inactive']));
                $message = 'Products deactivated successfully.';
                break;
            case 'update_stock':
                $products->each(fn($product) => $product->update(['stock' => $request->stock_value]));
                $message = 'Product stock updated successfully.';
                break;
            case 'delete':
                $products->each(function($product) {
                    if (!$product->carts()->exists()) {
                        $product->delete();
                    }
                });
                $message = 'Products deleted successfully.';
                break;
        }

        return redirect()->route('admin.products.index')
            ->with('success', $message);
    }

    /**
     * Update product stock.
     */
    public function updateStock(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'stock' => ['required', 'integer', 'min:0'],
        ]);

        $product->update(['stock' => $request->stock]);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product stock updated successfully.');
    }
}