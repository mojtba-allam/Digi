<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Category;
use Modules\Product\app\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();
        $products = Product::all();

        if ($categories->isEmpty() || $products->isEmpty()) {
            $this->command->warn('No categories or products found. Seeding skipped.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            DB::table('product_category')->insert([
                'category_id' => $categories->random()->id,
                'product_id' => $products->random()->id,
                'relationship_type' => fake()->randomElement(['primary', 'secondary', 'related']),
                'relationship_strength' => fake()->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
