<?php

namespace Modules\ContentManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\ContentManagement\app\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blog::factory()->count(10)->create();
    }
}
