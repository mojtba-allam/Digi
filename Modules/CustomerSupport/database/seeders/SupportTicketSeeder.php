<?php

namespace Modules\CustomerSupport\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CustomerSupport\app\Models\SupportTicket;

class SupportTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SupportTicket::factory()->count(10)->create();
    }
}
