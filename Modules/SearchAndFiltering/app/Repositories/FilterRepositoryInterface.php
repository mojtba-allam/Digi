<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\SearchAndFiltering\app\Models\Filter;

interface FilterRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): Filter;
    public function create(array $data): Filter;
    public function update(Filter $filter, array $data): Filter;
    public function delete(Filter $filter): bool;
    public function getByType(string $type): array;
}