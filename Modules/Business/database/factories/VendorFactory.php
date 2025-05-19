<?php

namespace Modules\Business\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Business\app\Models\Vendor;

class VendorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Vendor::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'company_name' => $this->faker->company(),
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
        ];
    }
}

