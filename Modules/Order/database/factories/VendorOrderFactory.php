<?php

namespace Modules\Order\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\Order\app\Models\Order;

class VendorOrderFactory extends Factory
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
            'vendor_id' => Vendor::factory(),
            'order_id' => Order::factory(),
        ];
    }
}

