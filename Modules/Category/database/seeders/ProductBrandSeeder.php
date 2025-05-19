<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Brand;
use Modules\Product\app\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = Brand::all();
        $products = Product::all();

        if ($brands->count() === 0 || $products->count() === 0) {
            $this->command->warn('No brands or products found. Seeding skipped.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            DB::table('product_brand')->insert([
                'brand_id' => $brands->random()->id,
                'product_id' => $products->random()->id,
                'relationship_type' => fake()->randomElement(['manufacturer', 'reseller', 'partner']),
                'relationship_strength' => fake()->numberBetween(1, 10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
