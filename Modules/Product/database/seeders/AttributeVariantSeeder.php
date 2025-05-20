<?php

namespace Modules\Product\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Product\app\Models\ProductAttribute;
use Modules\Product\app\Models\ProductVariant;

class AttributeVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $variants = ProductVariant::inRandomOrder()->take(10)->get();
        $attributes = ProductAttribute::inRandomOrder()->take(10)->get();

        foreach (range(1, 20) as $i) {
            DB::table('attribute_variant')->insert([
                'product_variant_id' => $variants->random()->id,
                'product_attribute_id' => $attributes->random()->id,
            ]);
        }
    }
}
