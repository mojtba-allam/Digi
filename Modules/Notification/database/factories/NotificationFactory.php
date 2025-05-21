<?php

namespace Modules\Notification\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notification\app\Models\Notification;
use Modules\Authorization\app\Models\User;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->sentence(),
            'read_at' => $this->faker->optional(0.3)->dateTimeBetween('-1 week', 'now'),
            'user_id' => User::factory(),
        ];
    }
}
