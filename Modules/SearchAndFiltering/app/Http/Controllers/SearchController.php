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
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $this->searches->paginate((int)$request->input('per_page', 10));
        return SearchResource::collection($page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSearchRequest $request)
    {
        $searchLog = $this->searches->create($request->validated());

        return $this->successResponse(new SearchResource($searchLog),
            __('searchandfiltering::messages.search.created'), 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(SearchLog $searchLog)
    {
        return new SearchResource($searchLog);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSearchRequest $request, SearchLog $searchLog)
    {
        $this->searches->update($searchLog, $request->validated());

        return $this->successResponse(
            __('searchandfiltering::messages.search.updated'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SearchLog $searchLog)
    {
        $this->searches->delete($searchLog);
        return $this->successResponse(
            __('searchandfiltering::messages.search.deleted'),
            200
        );
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
