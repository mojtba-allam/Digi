<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\Database\Seeders\AuthorizationDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Modules\Authorization\database\seeders\AuthorizationDatabaseSeeder::class,
            \Modules\Admin\database\seeders\AdminDatabaseSeeder::class,
            \Modules\Business\database\seeders\BusinessDatabaseSeeder::class,
            \Modules\User\database\seeders\UserDatabaseSeeder::class,
            \Modules\ContentManagement\database\seeders\ContentManagementDatabaseSeeder::class,
            \Modules\CustomerSupport\database\seeders\CustomerSupportDatabaseSeeder::class,
            \Modules\SearchAndFiltering\database\seeders\SearchAndFilteringDatabaseSeeder::class,
            \Modules\Reaction\database\seeders\ReactionDatabaseSeeder::class,
            \Modules\Notification\database\seeders\NotificationDatabaseSeeder::class,
            \Modules\List\database\seeders\ListDatabaseSeeder::class,
            \Modules\SearchAndFiltering\database\seeders\SearchAndFilteringDatabaseSeeder::class,
            \Modules\AnalyticsAndReporting\database\seeders\AnalyticsAndReportingDatabaseSeeder::class,
            \Modules\Cart\database\seeders\DatabaseSeeder::class,
            \Modules\Category\database\seeders\DatabaseSeeder::class,
            \Modules\CommissionAndPayout\database\seeders\DatabaseSeeder::class,
            \Modules\Order\database\seeders\DatabaseSeeder::class,
            \Modules\Payment\database\seeders\DatabaseSeeder::class,
            \Modules\Product\database\seeders\DatabaseSeeder::class,
            \Modules\PromotionAndCoupon\database\seeders\DatabaseSeeder::class,
        ]);
    }
}
