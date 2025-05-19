<?php
namespace Modules\Notification\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['sometimes','string'],
            'data' => ['sometimes','array'],
            'read_at' => ['sometimes','date'],
        ];
    }
}
