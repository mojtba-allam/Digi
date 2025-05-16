<?php

namespace Modules\Reaction\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Reaction\app\Models\Review;
use Modules\Reaction\app\Models\ReviewModeration;

class ReviewModerationFactory extends Factory
{
    protected $model = ReviewModeration::class;

    public function definition(): array
    {
        return [
            'review_id' => Review::factory(),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
        ];
    }
}