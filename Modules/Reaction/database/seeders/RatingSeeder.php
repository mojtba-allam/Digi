<?php

namespace Modules\Reaction\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Reaction\app\Models\Rating;

class RatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rating::factory()->count(50)->create();
    }
}
