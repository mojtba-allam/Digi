<?php

namespace Modules\Business\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Business\app\Models\VendorCommission;

class VendorCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VendorCommission::factory()->count(10)->create();
    }
}
