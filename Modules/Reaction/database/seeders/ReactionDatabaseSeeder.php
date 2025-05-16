<?php

namespace Modules\Reaction\database\seeders;

use Illuminate\Database\Seeder;

class ReactionDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ReviewDatabaseSeeder::class,
        ]);
    }
}