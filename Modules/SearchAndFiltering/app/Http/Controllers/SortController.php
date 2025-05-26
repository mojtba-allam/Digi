<?php

namespace Modules\SearchAndFiltering\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\SearchAndFiltering\app\Http\Resources\SortResource;
use Modules\SearchAndFiltering\app\Repositories\SortRepositoryInterface;
use Modules\SearchAndFiltering\app\Traits\ApiResponse;

class SortController extends Controller
{
    use ApiResponse;

    protected SortRepositoryInterface $sort;

    public function __construct(SortRepositoryInterface $sort)
    {
        $this->sort = $sort;
    }

    /**
     * Get available sort options.
     */
    public function getAvailableSortOptions()
    {
        $options = $this->sort->getAvailableSortOptions();

        return $this->successResponse([
            'options' => $options
        ]);
    }

    /**
     * Apply sorting to a collection.
     *
     * Note: This would typically be used internally by other controllers,
     * rather than as a direct API endpoint.
     */
    public function applySorting(Request $request)
    {
        $request->validate([
            'field' => 'required|string',
            'direction' => 'sometimes|string|in:asc,desc',
        ]);
        $collection = collect($request->input('items', []));

        $sorted = $this->sort->sort(
            $collection,
            $request->input('field'),
            $request->input('direction', 'asc')
        );

        return $this->successResponse([
            'sorted_items' => $sorted->values()->all(),
            'sort' => [
                'field' => $request->input('field'),
                'direction' => $request->input('direction', 'asc')
            ]
        ]);
    }
}
