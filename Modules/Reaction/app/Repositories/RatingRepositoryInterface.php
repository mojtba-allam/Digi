<?php

namespace Modules\Reaction\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Reaction\app\Models\Rating;

interface RatingRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): Rating;
    public function create(array $data): Rating;
    public function update(Rating $rating, array $data): Rating;
    public function delete(Rating $rating): bool;
}
