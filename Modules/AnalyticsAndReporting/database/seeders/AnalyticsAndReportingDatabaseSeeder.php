<?php

namespace Modules\AnalyticsAndReporting\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnalyticsAndReportingDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            AnalyticSeeder::class,
            ReportSeeder::class,
        ]);

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
