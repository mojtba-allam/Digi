<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Notification\app\Models\NotificationSubscription;
use Modules\Authorization\app\Models\User;

class NotificationSubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        // Get actual user IDs from database
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping notification subscription seeding');
            return;
        }

        // Create subscription preferences for each user
        foreach ($userIds as $userId) {
            // For each user, create 1-4 channel subscriptions
            $channels = ['email', 'sms', 'push', 'in-app'];
            $selectedChannels = array_slice($channels, 0, rand(1, 4));

            foreach ($selectedChannels as $channel) {
                NotificationSubscription::factory()->create([
                    'user_id' => $userId,
                    'channel' => $channel
                ]);
            }
        }
    }
}