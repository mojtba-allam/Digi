<?php

namespace Modules\Cart\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Cart\app\Models\Cart;

class CartFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Cart::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(1, 100), // Just use random numbers
        ];
    }
}

