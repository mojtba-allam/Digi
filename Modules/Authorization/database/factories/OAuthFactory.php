<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\OAuth;
use Modules\Authorization\app\Models\User;


class OAuthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = OAuth::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'provider' => $this->faker->randomElement(['google', 'facebook', 'twitter']),
            'provider_id' => $this->faker->randomNumber(5, true),
            'user_id' =>User::factory(),
            'user_type' => $this->faker->randomElement(['admin', 'vendor', 'customer', 'manager','support']),
        ];
    }
}

