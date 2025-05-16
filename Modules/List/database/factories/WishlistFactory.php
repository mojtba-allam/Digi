<?php

namespace Modules\List\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\List\app\Models\Wishlist;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100), // Fake user IDs
            'name' => $this->faker->words(2, true), // e.g., "birthday gifts"
        ];
    }
}
