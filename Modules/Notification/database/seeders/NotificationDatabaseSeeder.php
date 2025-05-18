<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            NotificationTemplateSeeder::class,
            NotificationSeeder::class,
            NotificationSubscriptionSeeder::class,
        ]);

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
