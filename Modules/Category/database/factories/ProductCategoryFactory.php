<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\app\Models\Category;
use Modules\Product\app\Models\Product;

class ProductCategoryFactory extends Factory
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
            'relationship_type' => $this->faker->randomElement(['primary', 'secondary', 'related']),
            'relationship_strength' => $this->faker->numberBetween(1, 10),
            'category_id' => Category::factory(),
            'product_id' => Product::factory(),
        ];
    }
}

