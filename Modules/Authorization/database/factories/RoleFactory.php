<?php

namespace Modules\Authorization\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\App\Models\Role;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $roleName = $this->faker->randomElement(['admin', 'vendor', 'customer', 'manager', 'support']);
        return [
            'name' => $roleName,
            'display_name' => ucfirst($roleName),
            'description' => ucfirst($roleName) . ' role',
            'guard_name' => 'web',
        ];
    }
}


