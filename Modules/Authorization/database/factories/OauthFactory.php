<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\App\Models\Oauth;

class OauthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Oauth::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'provider' => $this->faker->randomElement(['google', 'facebook', 'twitter']),
            'provider_id' => $this->faker->randomNumber(5, true),
            'user_id' =>$this->faker->numberBetween(1, 100),
        ];
    }
}

