<?php

namespace Modules\Payment\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Payment\app\Models\Payment;
use Modules\Payment\app\Models\Transaction;
use Illuminate\Support\Str;


class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'transaction_ref' => strtoupper(Str::random(12)),
            'payment_id' => Payment::factory(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'refunded']),
        ];
    }
}

