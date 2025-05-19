<?php

namespace Modules\Reaction\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
            'product_id' => $this->faker->numberBetween(1, 100),
            'user_id'    => $this->faker->numberBetween(1, 50),
            'rating'     => $this->faker->numberBetween(1, 5),
        ];
    }
}

