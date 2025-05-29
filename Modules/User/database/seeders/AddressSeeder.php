<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\app\Models\Address;
use Modules\User\app\Models\City;
use Modules\User\app\Models\Country;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::factory()->count(10)->create();
        $city = city::factory(20)
            ->recycle($country)
            ->create();
        Address::factory(30)
            ->recycle($country)
            ->recycle($city)
            ->create();
    }
}
