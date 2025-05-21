<?php

namespace Modules\Payment\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Payment\app\Models\Payment;
use Modules\Order\app\Models\Order;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing orders from database
        $orderIds = Order::pluck('id')->toArray();

        if (empty($orderIds)) {
            $this->command->warn('No orders found, skipping payment seeding');
            return;
        }

        // Create one payment for each order
        foreach ($orderIds as $orderId) {
            Payment::factory()->create([
                'order_id' => $orderId
            ]);
        }
    }
}