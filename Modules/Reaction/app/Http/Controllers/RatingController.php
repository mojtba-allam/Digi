<?php

namespace Modules\Reaction\app\Http\Controllers;

use Modules\Reaction\app\Http\Requests\StoreRatingRequest;
use Modules\Reaction\app\Http\Requests\UpdateRatingRequest;
use Modules\Reaction\app\Http\Resources\RatingResource;
use Modules\Reaction\app\Repositories\RatingRepositoryInterface;
use App\Http\Controllers\Controller;
use Modules\Reaction\app\Models\Rating;
use Illuminate\Http\Request;
use Modules\Reaction\app\Traits\ApiResponse;

class RatingController extends Controller
{
    use ApiResponse;

    protected RatingRepositoryInterface $ratings;

    public function __construct(RatingRepositoryInterface $ratings)
    {
        $this->ratings = $ratings;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $this->ratings->paginate((int)$request->input('per_page', 10));
        return RatingResource::collection($page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRatingRequest $request)
    {
        $rating = $this->ratings->create($request->validated());

        return $this->successResponse(new RatingResource($rating),
        __('reaction::messages.rating.created'), 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Rating $rating)
    {
        return new RatingResource($rating);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        $this->ratings->update($rating, $request->validated());

        return $this->successResponse(
        __('reaction::messages.rating.updated'),200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $rating)
    {
        $this->ratings->delete($rating);
        return $this->successResponse(
            __('reaction::messages.rating.deleted'),
            200
        );
    }
}
