<?php

namespace Modules\CustomerSupport\database\seeders;

use Illuminate\Database\Seeder;

class CustomerSupportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            FaqSeeder::class,
            ChatSeeder::class,
        ]);


    }
}
