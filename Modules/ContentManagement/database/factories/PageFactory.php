<?php

namespace Modules\ContentManagement\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ContentManagement\app\Models\Media;
use Modules\ContentManagement\app\Models\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(6),
            'slug' => $this->faker->unique()->slug(),
            'body' => $this->faker->paragraphs(3, true),
            'media_id' => Media::factory(),
        ];
    }
}
