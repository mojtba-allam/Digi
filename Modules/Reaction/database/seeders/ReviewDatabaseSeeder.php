<?php

namespace Modules\Reaction\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Reaction\app\Models\Review;
use Modules\Reaction\app\Models\ReviewModeration;

class ReviewDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 reviews with moderations
        Review::factory()
            ->count(50)
            ->create()
            ->each(function ($review) {
                ReviewModeration::factory()->create([
                    'review_id' => $review->id
                ]);
            });

        // Create 20 reviews without moderation (pending state)
        Review::factory()
            ->count(20)
            ->create();
    }
}