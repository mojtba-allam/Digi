<?php

namespace Modules\CustomerSupport\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSupportDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            FaqSeeder::class,
            SupportTicketSeeder::class,
            ChatSeeder::class,
        ]);


    }
}
