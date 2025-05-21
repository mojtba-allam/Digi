<?php

namespace Modules\List\app\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWishlistItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'wishlist_id' => 'required|exists:wishlists,id',
            'product_id' => 'required|exists:products,id',
        ];
    }
}
