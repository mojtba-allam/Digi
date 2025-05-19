<?php

namespace Modules\Business\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\Business\app\Models\VendorCommission;

class VendorCommissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = VendorCommission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'rate' => $this->faker->randomFloat(2, 0, 20), // نسبة العمولة بين 0 و 20%
            'vendor_id' => Vendor::factory(),
        ];
    }
}
