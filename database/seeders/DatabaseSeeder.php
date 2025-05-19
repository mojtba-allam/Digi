<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Modules\Reaction\database\seeders\ReactionDatabaseSeeder::class,
            \Modules\Notification\database\seeders\NotificationDatabaseSeeder::class,
            \Modules\List\database\seeders\ListDatabaseSeeder::class,
            \Modules\SearchAndFiltering\database\seeders\SearchAndFilteringDatabaseSeeder::class,
            \Modules\AnalyticsAndReporting\database\seeders\AnalyticsAndReportingDatabaseSeeder::class,
            \Modules\Cart\database\seeders\DatabaseSeeder::class,

        ]);
    }
}
