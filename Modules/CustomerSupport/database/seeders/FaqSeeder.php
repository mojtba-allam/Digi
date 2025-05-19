<?php

namespace Modules\CustomerSupport\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CustomerSupport\app\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Faq::factory()->count(10)->create();
    }
}
