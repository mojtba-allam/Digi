<?php

namespace Modules\User\database\seeders;

use Illuminate\Database\Seeder;
use Modules\User\app\Models\Address;
use Modules\User\app\Models\City;
use Modules\User\app\Models\Country;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        city::factory(20)->create();

    }
}
