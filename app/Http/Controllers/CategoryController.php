<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Category\app\Models\Category;
use Modules\Category\app\Models\Brand;
use Modules\Product\app\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories
     */
    public function index(): View
    {
        // Get featured categories (just get first 4)
        $featuredCategories = Category::withCount('products')
            ->limit(4)
            ->get();

        // Get all categories
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get();

        // Get popular brands
        $brands = Brand::withCount('products')
            ->orderBy('products_count', 'desc')
            ->limit(12)
            ->get();

        return view('categories.index', compact('featuredCategories', 'categories', 'brands'));
    }

    /**
     * Display the specified category
     */
    public function show(int $id, Request $request): View
    {
        $category = Category::findOrFail($id);

        // Get products in this category
        $query = Product::whereHas('categories', function ($q) use ($category) {
            $q->where('categories.id', $category->id);
        })->where('status', 'active');

        // Apply filters similar to ProductController
        if ($request->filled('brand')) {
            $query->whereHas('brands', function ($q) use ($request) {
                $q->where('brands.id', $request->brand);
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort', 'newest');
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
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->with(['categories', 'brands', 'product_media', 'reviews'])
            ->paginate(12)
            ->withQueryString();

        // Get brands available in this category
        $availableBrands = Brand::whereHas('products.categories', function ($q) use ($category) {
            $q->where('categories.id', $category->id);
        })->get();

        return view('categories.show', compact('category', 'products', 'availableBrands'));
    }

    /**
     * Get subcategories for a category
     */
    public function subcategories(string $id)
    {
        $subcategories = Category::where('parent_id', $id)
            ->where('status', 'active')
            ->withCount('products')
            ->get();

        return response()->json($subcategories);
    }
}