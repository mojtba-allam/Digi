<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\SearchAndFiltering\app\Models\SearchLog;

class EloquentSearchRepository implements SearchRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return SearchLog::paginate($perPage);
    }

    public function find(int $id): SearchLog
    {
        return SearchLog::findOrFail($id);
    }

    public function create(array $data): SearchLog
    {
        return SearchLog::create($data);
    }

    public function update(SearchLog $searchLog, array $data): SearchLog
    {
        $searchLog->update($data);
        return $searchLog;
    }

    public function delete(SearchLog $searchLog): bool
    {
        return (bool) $searchLog->delete();
    }

    public function search(string $query, array $options = []): LengthAwarePaginator
    {
        $searchQuery = SearchLog::query();
        $searchQuery->where('query', 'like', "%{$query}%");

        // Log the search
        if (isset($options['user_id'])) {
            $this->create([
                'query' => $query,
                'user_id' => $options['user_id']
            ]);
        }

        return $searchQuery->paginate($options['per_page'] ?? 15);
    }
}