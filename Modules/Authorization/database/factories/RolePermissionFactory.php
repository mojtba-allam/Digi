<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RolePermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'role_id' => \Modules\Authorization\App\Models\Role::factory(),
            'permission_id' => \Modules\Authorization\App\Models\Permission::factory(),
        ];
    }
}

