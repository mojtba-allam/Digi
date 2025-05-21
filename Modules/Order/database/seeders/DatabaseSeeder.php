<?php

namespace Modules\Order\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            OrderSeeder::class,
            OrderInvoiceSeeder::class,
            OrderStatusSeeder::class,
            OrderItemSeeder::class,
            ReturnRequestSeeder::class,
            VendorOrderSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
