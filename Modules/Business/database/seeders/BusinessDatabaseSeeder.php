<?php

namespace Modules\Business\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
