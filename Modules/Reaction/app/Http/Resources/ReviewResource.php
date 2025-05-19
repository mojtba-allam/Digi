<?php

namespace Modules\Reaction\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'user_id'    => $this->user_id,
            // show descriptive text on single‐item routes, otherwise the raw number
        'rating' => $this->when(
            $request->route('review'),
            function () {
                $labels = [
                    1 => 'Very Bad',
                    2 => 'Bad',
                    3 => 'Neutral',
                    4 => 'Good',
                    5 => 'Excellent',
                ];
                return $labels[$this->rating] ?? 'Unknown';
            },
            $this->rating
        ),
            'comment'    => $this->comment,
            // show only moderation status when we trying to see one review
            'status' => $this->when($request->route('review'), $this->whenLoaded('moderation', function () {
                return $this->moderation->status;
            })),
            // show created_at and updated_at only when we trying to see one review
            'created_at' => $this->when($request->route('review'), $this->created_at),
            'updated_at' => $this->when($request->route('review'), $this->updated_at),
        ];
    }
}
