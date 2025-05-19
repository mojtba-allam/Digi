<?php

namespace Modules\User\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\User\app\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'avatar' => $this->faker->imageUrl(200, 200, 'people'),
            'bio' => $this->faker->sentence(),
            'user_id' => User::factory(),
        ];
    }
}
