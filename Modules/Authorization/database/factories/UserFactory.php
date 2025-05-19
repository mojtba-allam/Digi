<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\App\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
        ];
    }
}

