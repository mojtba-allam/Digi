<?php

namespace Modules\User\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\User\app\Models\Address;
use Modules\User\App\Models\City;
use Modules\User\App\Models\Country;

class CityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'city' => $this->faker->city,
            'country_id' => Country::factory(),
        ];
    }
}
