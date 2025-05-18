<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\app\Models\Collection;
use Modules\Product\app\Models\Product;

class ProductCollectionFactory extends Factory
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
            'collection_id' => Collection::factory(),
        ];
    }
}

