<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints


        $this->call([
            NotificationTemplateSeeder::class,
            NotificationSeeder::class,
            NotificationSubscriptionSeeder::class,
        ]);

        // Re-enable foreign key constraints

    }
}
