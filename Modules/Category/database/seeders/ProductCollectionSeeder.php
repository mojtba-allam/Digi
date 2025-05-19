<?php

namespace Modules\Category\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Category\app\Models\Collection;
use Modules\Product\app\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $collections = Collection::all();

        if ($products->isEmpty() || $collections->isEmpty()) {
            $this->command->warn('No products or collections found. Seeding skipped.');
            return;
        }

        // Assign 20 product-collection links
        for ($i = 0; $i < 20; $i++) {
            DB::table('product_collection')->insert([
                'product_id' => $products->random()->id,
                'collection_id' => $collections->random()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
