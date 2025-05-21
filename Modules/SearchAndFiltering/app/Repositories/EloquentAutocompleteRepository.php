<?php

namespace Modules\SearchAndFiltering\app\Repositories;

use Modules\SearchAndFiltering\app\Models\SearchLog;
use Illuminate\Support\Facades\DB;

class EloquentAutocompleteRepository implements AutocompleteRepositoryInterface
{
    public function getSuggestions(string $query, int $limit = 10): array
    {
        return SearchLog::where('query', 'like', "{$query}%")
            ->select('query')
            ->distinct()
            ->limit($limit)
            ->pluck('query')
            ->toArray();
    }

    public function getPopularSearches(int $limit = 10): array
    {
        return SearchLog::select('query', DB::raw('count(*) as total'))
            ->groupBy('query')
            ->orderBy('total', 'desc')
            ->limit($limit)
            ->pluck('query')
            ->toArray();
    }

    public function getRecentSearches(int $userId, int $limit = 10): array
    {
        return SearchLog::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->pluck('query')
            ->toArray();
    }
}