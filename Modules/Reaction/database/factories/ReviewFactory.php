<?php

namespace Modules\Reaction\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reaction\app\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'product_id' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 50),
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->sentence(),
        ];
    }
}