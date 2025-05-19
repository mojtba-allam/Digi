<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;

class BusinessDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            VendorSeeder::class,
            VendorCommissionSeeder::class,
            VendorProfileSeeder::class,
        ]);
    }
}
