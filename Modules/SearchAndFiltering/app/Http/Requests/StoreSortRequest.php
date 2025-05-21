<?php

namespace Modules\SearchAndFiltering\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSortRequest extends FormRequest
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
            'field' => 'required|string|max:255',
            'direction' => 'required|string|in:asc,desc'
        ];
    }
}