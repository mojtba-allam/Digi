<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(10)->create();

        $parents = Category::inRandomOrder()->take(3)->get();

        foreach ($parents as $parent) {
            Category::factory()->count(2)->withParent($parent)->create();
        }
    }
}
