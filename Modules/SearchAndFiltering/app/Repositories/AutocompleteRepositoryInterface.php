<?php

namespace Modules\SearchAndFiltering\app\Repositories;

interface AutocompleteRepositoryInterface
{
    public function getSuggestions(string $query, int $limit = 10): array;
    public function getPopularSearches(int $limit = 10): array;
    public function getRecentSearches(int $userId, int $limit = 10): array;
}