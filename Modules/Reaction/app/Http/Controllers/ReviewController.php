<?php

namespace Modules\Reaction\app\Http\Controllers;

use Modules\Reaction\app\Http\Requests\StoreReviewRequest;
use Modules\Reaction\app\Http\Requests\UpdateReviewRequest;
use Modules\Reaction\app\Http\Resources\ReviewResource;
use Modules\Reaction\app\Repositories\ReviewRepositoryInterface;
use App\Http\Controllers\Controller;
use Modules\Reaction\app\Models\Review;
use Illuminate\Http\Request;
use Modules\Reaction\app\Traits\ApiResponse;

class ReviewController extends Controller
{
    use ApiResponse;

    protected ReviewRepositoryInterface $reviews;

    public function __construct(ReviewRepositoryInterface $reviews)
    {
        $this->reviews = $reviews;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $this->reviews->paginate((int)$request->input('per_page', 10));
        return ReviewResource::collection($page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $review = $this->reviews->create($request->validated());

        return $this->successResponse(new ReviewResource($review),
        __('reaction::messages.review.created'), 201);
    }

    /**
     * Show the specified resource.
     */
    public function show(Review $review)
    {
        return new ReviewResource($review->load('moderation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->reviews->update($review, $request->validated());

        return $this->successResponse(
        __('reaction::messages.review.updated'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->reviews->delete($review);
        return $this->successResponse(
        __('reaction::messages.review.deleted'), 200);
    }
}
