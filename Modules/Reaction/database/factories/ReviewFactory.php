<?php

namespace Modules\Reaction\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Product\app\Models\Product;
use Modules\Reaction\app\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'user_id' => User::factory(),
            'rating' => $this->faker->numberBetween(1, 5),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'comment' => $this->faker->sentence(),
        ];
    }
}
