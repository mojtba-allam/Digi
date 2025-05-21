<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\SearchAndFiltering\app\Models\Filter;

class EloquentFilterRepository implements FilterRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Filter::paginate($perPage);
    }

    public function find(int $id): Filter
    {
        return Filter::findOrFail($id);
    }

    public function create(array $data): Filter
    {
        return Filter::create($data);
    }

    public function update(Filter $filter, array $data): Filter
    {
        $filter->update($data);
        return $filter;
    }

    public function delete(Filter $filter): bool
    {
        return (bool) $filter->delete();
    }

    public function getByType(string $type): array
    {
        return Filter::where('type', $type)->get()->toArray();
    }
}