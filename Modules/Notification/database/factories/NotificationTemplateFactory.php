<?php

namespace Modules\Notification\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Notification\app\Models\NotificationTemplate;

class NotificationTemplateFactory extends Factory
{
    protected $model = NotificationTemplate::class;

    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['email', 'sms', 'push']),
            'subject' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
        ];
    }
}
