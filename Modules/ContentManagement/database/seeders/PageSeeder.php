<?php

namespace Modules\ContentManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContentManagement\app\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Page::factory()->count(10)->create();
    }
}
