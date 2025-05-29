<?php

namespace Modules\Reaction\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Reaction\database\factories\ReviewFactory;
use Modules\Reaction\app\Models\Review;

class ReactionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            Review::factory()
            ->count(50)
            ->create()
        ]);
    }
}
