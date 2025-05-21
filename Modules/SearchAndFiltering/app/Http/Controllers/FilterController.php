<?php

namespace Modules\SearchAndFiltering\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SearchAndFiltering\app\Http\Requests\StoreFilterRequest;
use Modules\SearchAndFiltering\app\Http\Requests\UpdateFilterRequest;
use Modules\SearchAndFiltering\app\Http\Resources\FilterResource;
use Modules\SearchAndFiltering\app\Models\Filter;
use Modules\SearchAndFiltering\app\Repositories\FilterRepositoryInterface;
use Modules\SearchAndFiltering\app\Traits\ApiResponse;

class FilterController extends Controller
{
    use ApiResponse;

    protected FilterRepositoryInterface $filters;

    public function __construct(FilterRepositoryInterface $filters)
    {
        $this->filters = $filters;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $this->filters->paginate((int)$request->input('per_page', 10));
        return FilterResource::collection($page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFilterRequest $request)
    {
        $filter = $this->filters->create($request->validated());

        return $this->successResponse(new FilterResource($filter),
            __('searchandfiltering::messages.filter.created'), 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Filter $filter)
    {
        return new FilterResource($filter);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilterRequest $request, Filter $filter)
    {
        $this->filters->update($filter, $request->validated());

        return $this->successResponse(
            __('searchandfiltering::messages.filter.updated'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Filter $filter)
    {
        $this->filters->delete($filter);
        return $this->successResponse(
            __('searchandfiltering::messages.filter.deleted'),
            200
        );
    }

    /**
     * Get filters by type.
     */
    public function getByType(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
        ]);

        $filters = $this->filters->getByType($request->input('type'));

        return FilterResource::collection(collect($filters));
    }
}