<?php

namespace Modules\Reaction\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'rating'  => 'sometimes|required|integer|min:1|max:5',
            'comment' => 'sometimes|nullable|string',
        ];
    }
}