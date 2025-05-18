<?php

namespace Modules\Cart\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Cart\app\Models\Cart;
use Modules\Product\app\Models\Product;

class CartItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'cart_id' => Cart::factory(),
            'quantity' => $this->faker->numberBetween(1, 5),
        ];
    }
}

