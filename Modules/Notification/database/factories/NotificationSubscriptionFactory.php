<?php

namespace Modules\Notification\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Notification\app\Models\NotificationSubscription;

class NotificationSubscriptionFactory extends Factory
{
    protected $model = NotificationSubscription::class;

    public function definition(): array
    {
        return [
            'channel' => $this->faker->randomElement(['email', 'sms', 'push', 'in-app']),
            'status' => $this->faker->randomElement(['active', 'paused', 'unsubscribed']),
            'user_id' => User::factory(),
        ];
    }
}
