<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\app\Models\Brand;
use Modules\Product\app\Models\Product;

class ProductBrandFactory extends Factory
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
            'relationship_type' => $this->faker->randomElement(['manufacturer', 'reseller', 'partner']),
            'relationship_strength' => $this->faker->numberBetween(1, 10),
            'brand_id' => Brand::factory(),
            'product_id' => Product::factory(),
        ];
    }
}

