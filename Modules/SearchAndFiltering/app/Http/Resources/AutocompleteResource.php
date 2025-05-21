<?php

namespace Modules\SearchAndFiltering\app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutocompleteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        // Since this resource might be used for simple string arrays
        if (is_string($this->resource)) {
            return ['value' => $this->resource];
        }

        return [
            'query' => $this->query ?? $this->resource,
            'created_at' => $this->created_at ?? null,
        ];
    }
}