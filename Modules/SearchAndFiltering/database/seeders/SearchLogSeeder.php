<?php

namespace Modules\SearchAndFiltering\database\seeders;

use Illuminate\Database\Seeder;
use Modules\SearchAndFiltering\app\Models\SearchLog;

class SearchLogSeeder extends Seeder
{
    public function run(): void
    {
        SearchLog::factory()->count(100)->create();
    }
}
