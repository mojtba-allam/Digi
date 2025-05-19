<?php
namespace Modules\Notification\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required','integer','exists:users,id'],
            'type'    => ['required','string'],
            'data'    => ['required','array'],
        ];
    }
}
