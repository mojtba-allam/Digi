<?php

namespace Modules\List\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\List\database\seeders\WishlistSeeder;
use Modules\List\database\seeders\WishlistItemSeeder;

class ListDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Temporarily disable foreign key constraints


        $this->call([
            WishlistSeeder::class,
            WishlistItemSeeder::class,
        ]);

        // Re-enable foreign key constraints

    }
}
