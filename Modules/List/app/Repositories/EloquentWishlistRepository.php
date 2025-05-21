<?php

namespace Modules\List\app\Repositories;

use Modules\List\app\Models\Wishlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentWishlistRepository implements WishlistRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Wishlist::with('items')->paginate($perPage);
    }

    public function find(int $id): Wishlist
    {
        return Wishlist::with('items')->findOrFail($id);
    }

    public function create(array $data): Wishlist
    {
        return Wishlist::create($data);
    }

    public function update(Wishlist $wishlist, array $data): Wishlist
    {
        $wishlist->update($data);
        return $wishlist;
    }

    public function delete(Wishlist $wishlist): bool
    {
        return (bool) $wishlist->delete();
    }
}
