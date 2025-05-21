<?php

namespace Modules\Reaction\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Product\app\Models\Product;
use Modules\Reaction\app\Models\Rating;

class RatingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Rating::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(), // Create a new product or use an existing one
            'user_id'    => User::factory(), // Create a new user or use an existing one
            'rating'     => $this->faker->numberBetween(1, 5),
        ];
    }
}

