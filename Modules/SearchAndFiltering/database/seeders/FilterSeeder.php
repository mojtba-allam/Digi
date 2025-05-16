<?php

namespace Modules\SearchAndFiltering\database\seeders;

use Illuminate\Database\Seeder;
use Modules\SearchAndFiltering\app\Models\Filter;

class FilterSeeder extends Seeder
{
    public function run(): void
    {
        Filter::factory()->count(50)->create();
    }
}
