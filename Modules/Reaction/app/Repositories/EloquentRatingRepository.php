<?php

namespace Modules\Reaction\app\Repositories;

use Modules\Reaction\app\Models\Rating;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentRatingRepository implements RatingRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Rating::paginate($perPage);
    }

    public function find(int $id): Rating
    {
        return Rating::findOrFail($id);
    }

    public function create(array $data): Rating
    {
        return Rating::create($data);
    }

    public function update(Rating $rating, array $data): Rating
    {
        $rating->update($data);
        return $rating;
    }

    public function delete(Rating $rating): bool
    {
        return (bool) $rating->delete();
    }
}
