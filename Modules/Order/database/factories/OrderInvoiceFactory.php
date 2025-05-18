<?php

namespace Modules\Order\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Order\app\Models\Order;
use Modules\Order\app\Models\OrderInvoice;

class OrderInvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = OrderInvoice::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'invoice_file' => 'invoices/' . $this->faker->uuid . '.pdf'
        ];
    }
}

