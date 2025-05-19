<?php

namespace Modules\CustomerSupport\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\CustomerSupport\app\Models\Chat;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'message' => $this->faker->sentence(),
            'sent_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'user_id' => User::factory(),
        ];
    }
}
