<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Admin\app\Models\Admin;
use Modules\Authorization\App\Models\TemporaryPermission;
use Modules\Authorization\App\Models\Permission;
use Modules\Authorization\App\Models\Role;

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
            'admin_id' => Admin::factory(),
            'granted_at' => $this->faker->dateTime(),
            'role_id' => Role::factory(),
            'expires_at' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'condition' => $this->faker->sentence(),
            'permission_id' => Permission::factory(),
        ];
    }
}

