<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Product\app\Models\Product;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Models\Brand;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index(Request $request): View
    {
        $query = Product::with(['categories', 'brands', 'product_media', 'reviews']);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('sku', 'like', "%{$searchTerm}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category);
            });
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->whereHas('brands', function ($q) use ($request) {
                $q->where('brands.id', $request->brand);
            });
        }

        // Price range filter
        if ($request->filled('price_range')) {
            $range = explode('-', $request->price_range);
            if (count($range) == 2) {
                $query->whereBetween('price', [(float)$range[0], (float)$range[1]]);
            }
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Rating filter
        if ($request->filled('min_rating')) {
            $query->whereHas('reviews', function ($q) use ($request) {
                $q->havingRaw('AVG(rating) >= ?', [$request->min_rating]);
            });
        }

        // Sorting
        $sortBy = $request->get('sort', 'featured');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'rating':
                $query->withAvg('reviews', 'rating')
                      ->orderBy('reviews_avg_rating', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            default: // featured
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Status filter (only active products for customers)
        $query->where('status', 'active');

        // Pagination
        $products = $query->paginate(12)->withQueryString();

        // Get filter options
        $categories = Category::all();
        $brands = Brand::all();

        return view('products.index', compact('products', 'categories', 'brands'));
    }

    /**
     * Display the specified product
     */
    public function show(string $id): View
    {
        $product = Product::with([
            'categories',
            'brands',
            'product_media',
            'product_variants',
            'reviews.user',
            'vendor'
        ])->findOrFail($id);

        // Get related products
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->where('status', 'active')
            ->limit(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    /**
     * Search products via AJAX
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%")
                  ->orWhere('sku', 'like', "%{$query}%");
            })
            ->limit(10)
            ->get(['id', 'name', 'price', 'sku']);

        return response()->json($products);
    }

    /**
     * Get product suggestions for autocomplete
     */
    public function suggestions(Request $request)
    {
        $query = $request->get('q');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Product::where('status', 'active')
            ->where('name', 'like', "%{$query}%")
            ->limit(5)
            ->pluck('name')
            ->unique()
            ->values();

        return response()->json($suggestions);
    }
}