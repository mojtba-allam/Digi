<?php

namespace Modules\Reaction\app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'product_id' => $this->product_id,
            'user_id'    => $this->user_id,
            // show descriptive text on single‐item routes, otherwise the raw number
        'rating' => $this->when(
            $request->route('rating'),
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
