<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\app\Models\Brand;

class BrandFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Brand::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
        ];
    }
}

