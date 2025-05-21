<?php

namespace Modules\List\app\Http\Controllers;

use Modules\List\app\Http\Requests\StoreWishlistRequest;
use Modules\List\app\Http\Requests\UpdateWishlistRequest;
use Modules\List\app\Http\Resources\WishlistResource;
use Modules\List\app\Repositories\WishlistRepositoryInterface;
use App\Http\Controllers\Controller;
use Modules\List\app\Models\Wishlist;
use Illuminate\Http\Request;
use Modules\List\app\Http\Traits\ApiResponse;

class WishlistController extends Controller
{
    use ApiResponse;

    protected WishlistRepositoryInterface $wishlists;

    public function __construct(WishlistRepositoryInterface $wishlists)
    {
        $this->wishlists = $wishlists;
    }

    public function index(Request $request)
    {
        $page = $this->wishlists->paginate((int)$request->input('per_page', 10));
        return WishlistResource::collection($page);
    }

    public function store(StoreWishlistRequest $request)
    {
        $wishlist = $this->wishlists->create($request->validated());
        return $this->successResponse(
            new WishlistResource($wishlist),
            __('list::messages.wishlist.created'),
            201
        );
    }

    public function show(Wishlist $wishlist)
    {
        return new WishlistResource($wishlist->load('items'));
    }

    public function update(UpdateWishlistRequest $request, Wishlist $wishlist)
    {
        $this->wishlists->update($wishlist, $request->validated());
        return $this->successResponse(
            __('list::messages.wishlist.updated'),
            200
        );
    }

    public function destroy(Wishlist $wishlist)
    {
        $this->wishlists->delete($wishlist);
        return $this->successResponse(
            __('list::messages.wishlist.deleted'),
            200
        );
    }
}
