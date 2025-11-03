<?php

namespace Modules\Authorization\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\Role;
use Modules\Authorization\app\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            // User management
            ['name' => 'users.view', 'display_name' => 'View Users', 'description' => 'Can view user list'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'description' => 'Can create new users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'description' => 'Can edit user details'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'description' => 'Can delete users'],
            
            // Product management
            ['name' => 'products.view', 'display_name' => 'View Products', 'description' => 'Can view product list'],
            ['name' => 'products.create', 'display_name' => 'Create Products', 'description' => 'Can create new products'],
            ['name' => 'products.edit', 'display_name' => 'Edit Products', 'description' => 'Can edit product details'],
            ['name' => 'products.delete', 'display_name' => 'Delete Products', 'description' => 'Can delete products'],
            
            // Order management
            ['name' => 'orders.view', 'display_name' => 'View Orders', 'description' => 'Can view order list'],
            ['name' => 'orders.edit', 'display_name' => 'Edit Orders', 'description' => 'Can edit order details'],
            ['name' => 'orders.delete', 'display_name' => 'Delete Orders', 'description' => 'Can delete orders'],
            
            // Vendor management
            ['name' => 'vendors.view', 'display_name' => 'View Vendors', 'description' => 'Can view vendor list'],
            ['name' => 'vendors.create', 'display_name' => 'Create Vendors', 'description' => 'Can create new vendors'],
            ['name' => 'vendors.edit', 'display_name' => 'Edit Vendors', 'description' => 'Can edit vendor details'],
            ['name' => 'vendors.delete', 'display_name' => 'Delete Vendors', 'description' => 'Can delete vendors'],
            
            // Category management
            ['name' => 'categories.view', 'display_name' => 'View Categories', 'description' => 'Can view category list'],
            ['name' => 'categories.create', 'display_name' => 'Create Categories', 'description' => 'Can create new categories'],
            ['name' => 'categories.edit', 'display_name' => 'Edit Categories', 'description' => 'Can edit category details'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Categories', 'description' => 'Can delete categories'],
            
            // Analytics
            ['name' => 'analytics.view', 'display_name' => 'View Analytics', 'description' => 'Can view analytics dashboard'],
            
            // Settings
            ['name' => 'settings.view', 'display_name' => 'View Settings', 'description' => 'Can view system settings'],
            ['name' => 'settings.edit', 'display_name' => 'Edit Settings', 'description' => 'Can edit system settings'],
            
            // Vendor specific permissions
            ['name' => 'vendor.products.manage', 'display_name' => 'Manage Own Products', 'description' => 'Can manage own products as vendor'],
            ['name' => 'vendor.orders.manage', 'display_name' => 'Manage Own Orders', 'description' => 'Can manage own orders as vendor'],
            ['name' => 'vendor.analytics.view', 'display_name' => 'View Own Analytics', 'description' => 'Can view own analytics as vendor'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }

        // Create roles
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'Full system access',
                'permissions' => [
                    'users.view', 'users.create', 'users.edit', 'users.delete',
                    'products.view', 'products.create', 'products.edit', 'products.delete',
                    'orders.view', 'orders.edit', 'orders.delete',
                    'vendors.view', 'vendors.create', 'vendors.edit', 'vendors.delete',
                    'categories.view', 'categories.create', 'categories.edit', 'categories.delete',
                    'analytics.view',
                    'settings.view', 'settings.edit',
                ]
            ],
            [
                'name' => 'vendor',
                'display_name' => 'Vendor',
                'description' => 'Vendor access to manage own products and orders',
                'permissions' => [
                    'vendor.products.manage',
                    'vendor.orders.manage',
                    'vendor.analytics.view',
                ]
            ],
            [
                'name' => 'customer',
                'display_name' => 'Customer',
                'description' => 'Customer access for shopping',
                'permissions' => []
            ],
        ];

        foreach ($roles as $roleData) {
            $role = Role::firstOrCreate(
                ['name' => $roleData['name']],
                [
                    'display_name' => $roleData['display_name'],
                    'description' => $roleData['description'],
                ]
            );

            // Assign permissions to role
            if (!empty($roleData['permissions'])) {
                $permissions = Permission::whereIn('name', $roleData['permissions'])->get();
                $role->permissions()->sync($permissions->pluck('id'));
            }
        }
    }
}