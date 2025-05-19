<?php

namespace Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Business\app\Models\Vendor;
use Modules\Order\app\Models\Order;
use Illuminate\Support\Facades\DB;

class VendorOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::inRandomOrder()->take(20)->get();
        $vendors = Vendor::inRandomOrder()->take(10)->pluck('id');

        foreach ($orders as $order) {
            DB::table('vendor_order')->insert([
                'order_id' => $order->id,
                'vendor_id' => $vendors->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
