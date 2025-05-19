<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\User\app\Models\Address;

class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['home', 'work']),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
        ];
    }
}
