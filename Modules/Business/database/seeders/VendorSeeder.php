<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Business\app\Models\Vendor;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::factory()->count(10)->create();
    }
}
