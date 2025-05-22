<?php

namespace Modules\Product\app\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'status'      => $this->status,
            'vendor_id'      => $this->vendor_id,
//            'categories'  => $this->categories->pluck('name'),
//            'brands'      => $this->brands->pluck('name'),
//            'collections' => $this->collections->pluck('name'),
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
