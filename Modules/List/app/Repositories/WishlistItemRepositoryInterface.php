<?php

namespace Modules\List\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\List\app\Models\WishlistItem;

interface WishlistItemRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): WishlistItem;
    public function create(array $data): WishlistItem;
    public function update(WishlistItem $wishlistItem, array $data): WishlistItem;
    public function delete(WishlistItem $wishlistItem): bool;
}
