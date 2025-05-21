<?php

namespace Modules\AnalyticsAndReporting\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalyticsAndReportingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints


        $this->call([
            AnalyticSeeder::class,
            ReportSeeder::class,
        ]);

        // Re-enable foreign key constraints

    }
}
