<?php

use Illuminate\Support\Facades\Route;
use Modules\SearchAndFiltering\app\Http\Controllers\AutocompleteController;
use Modules\SearchAndFiltering\app\Http\Controllers\FilterController;
use Modules\SearchAndFiltering\app\Http\Controllers\SearchController;
use Modules\SearchAndFiltering\app\Http\Controllers\SortController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Search routes
Route::get('search', [SearchController::class, 'search']);
Route::apiResource('searches', SearchController::class);

// Filter routes
Route::get('filters/type', [FilterController::class, 'getByType']);
Route::apiResource('filters', FilterController::class);

// Autocomplete routes
Route::get('autocomplete/suggestions', [AutocompleteController::class, 'getSuggestions']);
Route::get('autocomplete/popular', [AutocompleteController::class, 'getPopularSearches']);
Route::get('autocomplete/recent', [AutocompleteController::class, 'getRecentSearches']);

// Sort routes
Route::get('sort/options', [SortController::class, 'getAvailableSortOptions']);
Route::post('sort/apply', [SortController::class, 'applySorting']);