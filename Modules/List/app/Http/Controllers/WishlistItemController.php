<?php

namespace Modules\List\app\Http\Controllers;

use Modules\List\app\Http\Requests\StoreWishlistItemRequest;
use Modules\List\app\Http\Requests\UpdateWishlistItemRequest;
use Modules\List\app\Http\Resources\WishlistItemResource;
use Modules\List\app\Repositories\WishlistItemRepositoryInterface;
use App\Http\Controllers\Controller;
use Modules\List\app\Models\WishlistItem;
use Illuminate\Http\Request;
use Modules\List\app\Http\Traits\ApiResponse;

class WishlistItemController extends Controller
{
    use ApiResponse;

    protected WishlistItemRepositoryInterface $wishlistItems;

    public function __construct(WishlistItemRepositoryInterface $wishlistItems)
    {
        $this->wishlistItems = $wishlistItems;
    }

    public function index(Request $request)
    {
        $page = $this->wishlistItems->paginate((int)$request->input('per_page', 10));
        return WishlistItemResource::collection($page);
    }

    public function store(StoreWishlistItemRequest $request)
    {
        $wishlistItem = $this->wishlistItems->create($request->validated());
        return $this->successResponse(
            new WishlistItemResource($wishlistItem),
            __('list::messages.wishlist_item.created'),
            201
        );
    }

    public function show(WishlistItem $wishlistItem)
    {
        return new WishlistItemResource($wishlistItem->load('wishlist'));
    }

    public function update(UpdateWishlistItemRequest $request, WishlistItem $wishlistItem)
    {
        $this->wishlistItems->update($wishlistItem, $request->validated());
        return $this->successResponse(
            __('list::messages.wishlist_item.updated'),
            200
        );
    }

    public function destroy(WishlistItem $wishlistItem)
    {
        $this->wishlistItems->delete($wishlistItem);
        return $this->successResponse(
            __('list::messages.wishlist_item.deleted'),
            200
        );
    }
}
