<?php

namespace Modules\Business\App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderStatusRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => 'required|string|in:confirmed,processing,shipped,delivered',
            'notes' => 'nullable|string|max:500',
            'tracking_number' => 'nullable|string|max:100'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.required' => 'Order status is required.',
            'status.in' => 'Invalid order status selected.',
            'notes.max' => 'Notes cannot exceed 500 characters.',
            'tracking_number.max' => 'Tracking number cannot exceed 100 characters.'
        ];
    }
}