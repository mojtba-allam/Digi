<?php

namespace Modules\List\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\List\app\Models\Wishlist;
use Modules\Authorization\app\Models\User;

class WishlistFactory extends Factory
{
    protected $model = Wishlist::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->words(2, true), // e.g., "birthday gifts"
        ];
    }
}
