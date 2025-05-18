<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\Product\app\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock' => $this->faker->numberBetween(0, 1000),
            'status' => $this->faker->randomElement(['active', 'inactive', 'out_of_stock']),
            'vendor_id' => Vendor::factory(),
        ];
    }
}

