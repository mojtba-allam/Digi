<?php

namespace Modules\CustomerSupport\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\CustomerSupport\app\Models\Chat;
use Modules\Admin\app\Models\Admin;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $senderTypes = [User::class, Admin::class];
    $senderType = $this->faker->randomElement($senderTypes);

    $senderId = $senderType::inRandomOrder()->first()?->id ?? 1;

    return [
        'message' => $this->faker->sentence,
        'sent_at' => now(),
        'sender_id' => $senderId,
        'sender_type' => $senderType,
    ];
    }
}
