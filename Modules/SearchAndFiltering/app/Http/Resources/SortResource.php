<?php

namespace Modules\SearchAndFiltering\app\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SortResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        if (is_string($this->resource)) {
            return ['value' => $this->resource];
        }

        return [
            'field' => $this->field ?? $this->resource['field'] ?? null,
            'direction' => $this->direction ?? $this->resource['direction'] ?? 'asc',
        ];
    }
}