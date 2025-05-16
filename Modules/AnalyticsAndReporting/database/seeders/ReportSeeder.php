<?php

namespace Modules\AnalyticsAndReporting\database\seeders;

use Illuminate\Database\Seeder;
use Modules\AnalyticsAndReporting\app\Models\Report;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        Report::factory()->count(30)->create();
    }
}
