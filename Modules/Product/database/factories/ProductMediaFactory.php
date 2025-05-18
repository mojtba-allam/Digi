<?php

namespace Modules\Product\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ContentManagement\app\Models\Media;
use Modules\Product\app\Models\Product;
use Modules\Product\app\Models\ProductVariant;
use Modules\PromotionAndCoupon\app\Models\Promotion;

class ProductMediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\Product\app\Models\ProductMedia::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'media_type' => $this->faker->randomElement(['image', 'video', 'audio']),
            'url' => $this->faker->imageUrl(640, 480, 'product', true),
            'media_id' => Media::factory(),
            'product_variant_id' => ProductVariant::factory(),
            'promotion_id' => Promotion::factory(),
            'media_order' => $this->faker->numberBetween(1, 10),
            'alt_text' => $this->faker->sentence(3),
            'caption' => $this->faker->sentence(6),
        ];
    }
}

