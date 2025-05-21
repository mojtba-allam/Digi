<?php

namespace Modules\SearchAndFiltering\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'query' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id'
        ];
    }
}