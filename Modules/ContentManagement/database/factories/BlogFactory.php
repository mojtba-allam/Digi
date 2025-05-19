<?php

namespace Modules\ContentManagement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ContentManagement\app\Models\Blog;
use Modules\ContentManagement\app\Models\Media;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'media_id' => Media::factory(),
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->unique()->slug(),
            'content' => $this->faker->paragraphs(4, true),
        ];
    }
}

