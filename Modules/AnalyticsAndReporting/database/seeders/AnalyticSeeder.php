<?php

namespace Modules\AnalyticsAndReporting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\AnalyticsAndReporting\app\Models\Analytic;

class AnalyticSeeder extends Seeder
{
    public function run(): void
    {
        Analytic::factory()->count(100)->create();
    }
}
