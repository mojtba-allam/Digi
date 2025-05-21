<?php

namespace Modules\Reaction\database\seeders;

use Illuminate\Database\Seeder;

class ReactionSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ReviewSeeder::class,
            RatingSeeder::class,
        ]);
    }
}
