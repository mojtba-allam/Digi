<?php

namespace Modules\Business\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Business\app\Models\Vendor;
use Modules\Business\app\Models\VendorProfile;

class VendorProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = VendorProfile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tax_id' => $this->faker->bothify('??########'),
            'description' => $this->faker->paragraph(),
            'vendor_id' => Vendor::factory(),
        ];
    }
}
