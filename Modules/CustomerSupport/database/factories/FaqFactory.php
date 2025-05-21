<?php

namespace Modules\CustomerSupport\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\CustomerSupport\app\Models\Faq;

class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'question' => $this->faker->sentence(),
            'answer' => $this->faker->realText(200),
        ];
    }
}

