<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Database\Eloquent\Collection;

class EloquentSortRepository implements SortRepositoryInterface
{
    public function sort(Collection $collection, string $field, string $direction = 'asc'): Collection
    {
        return $collection->sortBy($field, SORT_REGULAR, $direction === 'desc');
    }

    public function getAvailableSortOptions(): array
    {
        return [
            'created_at' => 'Date',
            'name' => 'Name',
            'price' => 'Price',
            'popularity' => 'Popularity'
        ];
    }
}