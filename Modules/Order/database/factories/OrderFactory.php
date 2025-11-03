<?php

namespace Modules\Order\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\Order\app\Models\Order;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 50, 1500);
        $discountAmount = $this->faker->randomFloat(2, 0, $subtotal * 0.2);
        $shippingAmount = $this->faker->randomFloat(2, 5, 50);
        $taxAmount = $subtotal * 0.1;
        $totalAmount = $subtotal - $discountAmount + $shippingAmount + $taxAmount;
        
        $address = [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber(),
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
        ];
        
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'order_number' => 'ORD-' . strtoupper($this->faker->unique()->bothify('??##??##')),
            'status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'subtotal' => $subtotal,
            'discount_amount' => $discountAmount,
            'shipping_amount' => $shippingAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'currency' => 'USD',
            'billing_address' => json_encode($address),
            'shipping_address' => json_encode($address),
            'notes' => $this->faker->optional()->sentence(),
            'shipped_at' => $this->faker->optional(0.5)->dateTimeBetween('-30 days', 'now'),
            'delivered_at' => $this->faker->optional(0.3)->dateTimeBetween('-20 days', 'now'),
        ];
    }
}

