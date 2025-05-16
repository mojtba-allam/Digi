<?php

namespace Modules\SearchAndFiltering\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\SearchAndFiltering\app\Models\Filter;

class FilterFactory extends Factory
{
    protected $model = Filter::class;

    public function definition(): array
    {
        $filterTypes = ['price', 'color', 'size', 'brand', 'category'];

        return [
            'type' => $this->faker->randomElement($filterTypes),
            'value' => $this->faker->word(),
        ];
    }
}
