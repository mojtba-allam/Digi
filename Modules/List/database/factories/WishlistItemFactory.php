<?php

namespace Modules\List\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\List\app\Models\WishlistItem;
use Modules\List\app\Models\Wishlist;
use Modules\Product\app\Models\Product;

class WishlistItemFactory extends Factory
{
    protected $model = WishlistItem::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(), // Create a new product or use an existing one
            'wishlist_id' => Wishlist::factory(), // Create a new wishlist or use an existing one
        ];
    }
}
