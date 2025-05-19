<?php

namespace Modules\Reaction\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Reaction\app\Models\Review;

interface ReviewRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): Review;
    public function create(array $data): Review;
    public function update(Review $review, array $data): Review;
    public function delete(Review $review): bool;
}
