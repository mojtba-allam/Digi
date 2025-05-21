<?php

namespace Modules\SearchAndFiltering\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilterRequest extends FormRequest
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
            'type' => 'required|string|max:255',
            'value' => 'required|string|max:255'
        ];
    }
}