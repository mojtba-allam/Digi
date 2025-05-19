<?php

namespace Modules\CustomerSupport\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\CustomerSupport\app\Models\SupportTicket;

class SupportTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = SupportTicket::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'subject' => $this->faker->sentence(),
            'message' => $this->faker->text(200),
            'status' => $this->faker->randomElement(['open', 'pending', 'closed']),
            'history' => $this->faker->paragraphs(2, true),
            'user_id' => User::factory(),
        ];
    }
}

