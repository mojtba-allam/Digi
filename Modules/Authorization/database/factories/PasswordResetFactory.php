<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\App\Models\PasswordReset;

class PasswordResetFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = PasswordReset::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => \Modules\Authorization\App\Models\User::factory(),
            'token' => $this->faker->uuid(),
            'created_at' => $this->faker->dateTime(),
        ];
    }
}
