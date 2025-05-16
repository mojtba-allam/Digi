<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\app\Models\NotificationTemplate;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        NotificationTemplate::factory()->count(10)->create();
    }
}
