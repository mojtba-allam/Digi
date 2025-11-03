<?php

namespace Modules\Admin\App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:active,inactive,draft'],
            'vendor_id' => ['required', 'exists:vendors,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'brands' => ['array'],
            'brands.*' => ['exists:brands,id'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'description.required' => 'The product description is required.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.',
            'stock.required' => 'The stock quantity is required.',
            'stock.integer' => 'The stock must be a whole number.',
            'stock.min' => 'The stock cannot be negative.',
            'vendor_id.required' => 'A vendor must be selected.',
            'vendor_id.exists' => 'The selected vendor is invalid.',
            'categories.required' => 'At least one category must be selected.',
            'categories.*.exists' => 'One or more selected categories are invalid.',
            'brands.*.exists' => 'One or more selected brands are invalid.',
        ];
    }
}