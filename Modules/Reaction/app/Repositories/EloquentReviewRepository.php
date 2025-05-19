<?php

namespace Modules\Reaction\app\Repositories;

use Modules\Reaction\app\Models\Review;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentReviewRepository implements ReviewRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Review::with('moderation')->paginate($perPage);
    }

    public function find(int $id): Review
    {
        return Review::with('moderation')->findOrFail($id);
    }

    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function update(Review $review, array $data): Review
    {
        $review->update($data);
        return $review;
    }

    public function delete(Review $review): bool
    {
        return (bool) $review->delete();
    }
}
