<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductVariant;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'variant_type' => $this->faker->randomElement(['color', 'size', 'material', 'style']),
            'value' => $this->faker->word(),
            'sku' => strtoupper($this->faker->bothify('??###')),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'product_id' => Product::factory(),
        ];
    }
}

