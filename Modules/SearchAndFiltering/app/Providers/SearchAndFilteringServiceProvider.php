<?php

namespace Modules\SearchAndFiltering\app\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\SearchAndFiltering\app\Repositories\AutocompleteRepositoryInterface;
use Modules\SearchAndFiltering\app\Repositories\EloquentAutocompleteRepository;
use Modules\SearchAndFiltering\app\Repositories\EloquentFilterRepository;
use Modules\SearchAndFiltering\app\Repositories\EloquentSearchRepository;
use Modules\SearchAndFiltering\app\Repositories\EloquentSortRepository;
use Modules\SearchAndFiltering\app\Repositories\FilterRepositoryInterface;
use Modules\SearchAndFiltering\app\Repositories\SearchRepositoryInterface;
use Modules\SearchAndFiltering\app\Repositories\SortRepositoryInterface;

class SearchAndFilteringServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            SearchRepositoryInterface::class,
            EloquentSearchRepository::class
        );
        $this->app->bind(
            FilterRepositoryInterface::class,
            EloquentFilterRepository::class
        );
        $this->app->bind(
            AutocompleteRepositoryInterface::class,
            EloquentAutocompleteRepository::class
        );
        $this->app->bind(
            SortRepositoryInterface::class,
            EloquentSortRepository::class
        );
    }

    public function boot(): void
    {
        // make __('searchandfiltering::messages.key') work
        $this->loadTranslationsFrom(
            module_path('SearchAndFiltering', 'Resources/lang'),
            'searchandfiltering'
        );
    }
}