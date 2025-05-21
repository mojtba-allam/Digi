<?php

namespace Modules\SearchAndFiltering\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SearchAndFiltering\app\Http\Resources\AutocompleteResource;
use Modules\SearchAndFiltering\app\Repositories\AutocompleteRepositoryInterface;
use Modules\SearchAndFiltering\app\Traits\ApiResponse;

class AutocompleteController extends Controller
{
    use ApiResponse;

    protected AutocompleteRepositoryInterface $autocomplete;

    public function __construct(AutocompleteRepositoryInterface $autocomplete)
    {
        $this->autocomplete = $autocomplete;
    }

    /**
     * Get autocomplete suggestions.
     */
    public function getSuggestions(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:1',
            'limit' => 'sometimes|integer|min:1|max:20',
        ]);

        $suggestions = $this->autocomplete->getSuggestions(
            $request->input('query'),
            $request->input('limit', 10)
        );

        return $this->successResponse([
            'suggestions' => $suggestions,
            'count' => count($suggestions)
        ]);
    }

    /**
     * Get popular searches.
     */
    public function getPopularSearches(Request $request)
    {
        $request->validate([
            'limit' => 'sometimes|integer|min:1|max:20',
        ]);

        $popular = $this->autocomplete->getPopularSearches(
            $request->input('limit', 10)
        );

        return $this->successResponse([
            'popular_searches' => $popular,
            'count' => count($popular)
        ]);
    }

    /**
     * Get recent searches for a user.
     */
    public function getRecentSearches(Request $request)
    {
        $request->validate([
            'limit' => 'sometimes|integer|min:1|max:20',
        ]);

        // if (!Auth::check()) {
        //     return $this->errorResponse('Unauthorized', 401);
        // }

        $recent = $this->autocomplete->getRecentSearches(
            Auth::id(),
            $request->input('limit', 10)
        );

        return $this->successResponse([
            'recent_searches' => $recent,
            'count' => count($recent)
        ]);
    }
}