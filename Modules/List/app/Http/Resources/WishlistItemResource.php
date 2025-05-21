<?php

namespace Modules\List\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WishlistItemResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'wishlist_id' => $this->wishlist_id,
            'product_id' => $this->product_id,
            'added_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
