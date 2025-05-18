<?php

namespace Modules\Cart\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Cart\app\Models\Cart;
use Modules\Product\app\Models\Product;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $carts = Cart::all();

        foreach ($carts as $cart) {
            DB::table('cart_items')->insert([
                'cart_id' => $cart->id,
                'product_id' => Product::factory()->create()->id,
                'quantity' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
