<?php

namespace Modules\SearchAndFiltering\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\SearchAndFiltering\app\Http\Requests\StoreSearchRequest;
use Modules\SearchAndFiltering\app\Http\Requests\UpdateSearchRequest;
use Modules\SearchAndFiltering\app\Http\Resources\SearchResource;
use Modules\SearchAndFiltering\app\Models\SearchLog;
use Modules\SearchAndFiltering\app\Repositories\SearchRepositoryInterface;
use Modules\SearchAndFiltering\app\Traits\ApiResponse;

class SearchController extends Controller
{
    use ApiResponse;

    protected SearchRepositoryInterface $searches;

    public function __construct(SearchRepositoryInterface $searches)
    {
        $this->searches = $searches;
    }
    /**
     * Search within the application.
     */
    
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string|min:2',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $options = [
            'per_page' => $request->input('per_page', 15)
        ];

        if (Auth::check()) {
            $options['user_id'] = Auth::id();
        }

        $results = $this->searches->search($request->input('query'), $options);

        return SearchResource::collection($results);
    }
}
