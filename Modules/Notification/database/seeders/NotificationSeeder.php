<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\app\Models\Notification;
use Modules\Authorization\app\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // Get actual user IDs from database
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping notification seeding');
            return;
        }

        // Create 2-5 notifications for each user
        foreach ($userIds as $userId) {
            $notificationCount = rand(2, 5);
            Notification::factory()->count($notificationCount)->create([
                'user_id' => $userId
            ]);
        }
    }
}