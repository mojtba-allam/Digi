<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\App\Models\TemporaryPermission;

class TemporaryPermissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = TemporaryPermission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'admin_id' => $this->faker->numberBetween(1, 10),
            'granted_at' => $this->faker->dateTime(),
            'role_id' => \Modules\Authorization\App\Models\Role::factory(),
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'condition' => $this->faker->sentence(),
            'permission_id' => \Modules\Authorization\App\Models\Permission::factory(),
        ];
    }
}

