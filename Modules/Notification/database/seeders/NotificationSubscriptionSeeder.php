<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\app\Models\NotificationSubscription;

class NotificationSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        NotificationSubscription::factory()->count(20)->create();
    }
}