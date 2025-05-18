<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\Order\app\Models\OrderItem;
use Modules\Order\app\Models\ReturnRequest;
use Modules\Product\app\Models\ProductVariant;

class ReturnRequestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = ReturnRequest::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'product_variant_id' => ProductVariant::factory(),
            'order_item_id' => OrderItem::factory(),
            'reason' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected']),
            'history' => json_encode([
                ['status' => 'pending', 'timestamp' => now()->subDays(2)],
                ['status' => 'approved', 'timestamp' => now()],
            ]),
            'vendor_id' => Vendor::factory(),
        ];
    }
}

