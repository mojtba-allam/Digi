<?php

namespace Modules\SearchAndFiltering\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SearchAndFilteringDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints


        $this->call([
            FilterSeeder::class,
            SearchLogSeeder::class,
        ]);

        // Re-enable foreign key constraints

    }
}
