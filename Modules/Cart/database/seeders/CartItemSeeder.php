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
        $products = Product::all();

        if ($products->isEmpty()) {
            return;
        }

        foreach ($carts as $cart) {
            $product = $products->random();
            $quantity = rand(1, 5);
            
            DB::table('cart_items')->insert([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'product_variant_id' => null,
                'quantity' => $quantity,
                'price' => $product->price,
                'options' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
