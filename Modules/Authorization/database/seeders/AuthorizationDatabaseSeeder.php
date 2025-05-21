<?php

namespace Modules\Authorization\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorizationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
            TemporaryPermissionSeeder::class,
            UserSeeder::class,
            OAuthSeeder::class,
            PasswordResetSeeder::class,
        ]);

    }
}
