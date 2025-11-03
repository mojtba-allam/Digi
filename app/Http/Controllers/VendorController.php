<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Business\app\Models\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of vendors
     */
    public function index(): View
    {
        $vendors = Vendor::where('status', 'active')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->has('products', '>=', 1, 'and', function ($query) {
                $query->where('status', 'active');
            })
            ->orderBy('products_count', 'desc')
            ->paginate(12);

        return view('vendors.index', compact('vendors'));
    }

    /**
     * Display the specified vendor
     */
    public function show(int $id): View
    {
        $vendor = Vendor::where('status', 'active')
            ->withCount(['products' => function ($query) {
                $query->where('status', 'active');
            }])
            ->has('products', '>=', 1, 'and', function ($query) {
                $query->where('status', 'active');
            })
            ->findOrFail($id);

        $products = $vendor->products()
            ->where('status', 'active')
            ->with(['categories', 'brands', 'product_media'])
            ->paginate(12);

        return view('vendors.show', compact('vendor', 'products'));
    }
}
