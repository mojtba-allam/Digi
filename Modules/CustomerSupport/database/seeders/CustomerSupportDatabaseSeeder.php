<?php

namespace Modules\CustomerSupport\Database\Seeders;

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
            SupportTicketSeeder::class,
            ChatSeeder::class,
        ]);    }
}
