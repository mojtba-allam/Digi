<?php

namespace Modules\Category\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Category\app\Models\Collection;

class CollectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Collection::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
        ];
    }
}

