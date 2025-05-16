<?php

namespace Modules\List\database\seeders;

use Illuminate\Database\Seeder;
use Modules\List\app\Models\WishlistItem;

class WishlistItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WishlistItem::factory()->count(1000)->create();
    }
}
