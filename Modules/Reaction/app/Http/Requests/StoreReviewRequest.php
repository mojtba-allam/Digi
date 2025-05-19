<?php

namespace Modules\Reaction\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'product_id' => 'required|exists:products,id',
            'user_id'    => 'required|exists:users,id',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string',
        ];
    }
}