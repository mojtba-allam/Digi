<?php

namespace Modules\List\app\Repositories;

use Modules\List\app\Models\WishlistItem;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentWishlistItemRepository implements WishlistItemRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return WishlistItem::with('wishlist')->paginate($perPage);
    }

    public function find(int $id): WishlistItem
    {
        return WishlistItem::with('wishlist')->findOrFail($id);
    }

    public function create(array $data): WishlistItem
    {
        return WishlistItem::create($data);
    }

    public function update(WishlistItem $wishlistItem, array $data): WishlistItem
    {
        $wishlistItem->update($data);
        return $wishlistItem;
    }

    public function delete(WishlistItem $wishlistItem): bool
    {
        return (bool) $wishlistItem->delete();
    }
}
