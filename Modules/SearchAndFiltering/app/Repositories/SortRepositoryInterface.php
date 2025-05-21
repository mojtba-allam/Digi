<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Database\Eloquent\Collection;

interface SortRepositoryInterface
{
    public function sort(Collection $collection, string $field, string $direction = 'asc'): Collection;
    public function getAvailableSortOptions(): array;
}