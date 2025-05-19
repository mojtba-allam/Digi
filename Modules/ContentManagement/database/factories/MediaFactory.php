<?php

namespace Modules\ContentManagement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ContentManagement\app\Models\Media;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(['image', 'video', 'audio', 'document']),
            'url' => $this->faker->imageUrl(),
        ];
    }
}

