<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\app\Models\Notification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::factory()->count(50)->create();
    }
}