<?php

namespace Modules\List\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\List\app\Models\WishlistItem;
use Modules\List\app\Models\Wishlist;

class WishlistItemFactory extends Factory
{
    protected $model = WishlistItem::class;

    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 50), // Fake product IDs
            'wishlist_id' => Wishlist::factory(), // Create a new wishlist or use an existing one
        ];
    }
}
