<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Product\app\Models\ProductAttribute;
use Modules\Product\app\Models\ProductVariant;

class AttributeVariantFactory extends Factory
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
            'product_variant_id' => ProductVariant::factory(),
            'product_attribute_id' => ProductAttribute::factory(),
        ];
    }
}

