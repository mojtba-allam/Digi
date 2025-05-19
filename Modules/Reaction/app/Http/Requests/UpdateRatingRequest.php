<?php

namespace Modules\Reaction\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'rating' => 'sometimes|required|integer|min:1|max:5',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
