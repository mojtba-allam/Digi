<?php

namespace Modules\List\database\seeders;

use Illuminate\Database\Seeder;
use Modules\List\app\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Wishlist::factory()->count(30)->create();
    }
}
