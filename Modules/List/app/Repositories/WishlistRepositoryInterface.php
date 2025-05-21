<?php

namespace Modules\List\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\List\app\Models\Wishlist;

interface WishlistRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): Wishlist;
    public function create(array $data): Wishlist;
    public function update(Wishlist $wishlist, array $data): Wishlist;
    public function delete(Wishlist $wishlist): bool;
}
