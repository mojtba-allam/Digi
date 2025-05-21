<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\SearchAndFiltering\app\Models\SearchLog;

interface SearchRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function find(int $id): SearchLog;
    public function create(array $data): SearchLog;
    public function update(SearchLog $searchLog, array $data): SearchLog;
    public function delete(SearchLog $searchLog): bool;
    public function search(string $query, array $options = []): LengthAwarePaginator;
}