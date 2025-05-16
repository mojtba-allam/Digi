<?php

namespace Modules\SearchAndFiltering\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SearchAndFilteringDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            FilterSeeder::class,
            SearchLogSeeder::class,
        ]);

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
