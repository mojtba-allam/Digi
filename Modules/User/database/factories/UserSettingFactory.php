<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\User\app\Models\UserSetting;

class UserSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = UserSetting::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'privacy_settings' => $this->faker->randomElement(['public', 'private', 'friends-only']),
            'notifications_enabled' => $this->faker->boolean(),
        ];
    }
}

