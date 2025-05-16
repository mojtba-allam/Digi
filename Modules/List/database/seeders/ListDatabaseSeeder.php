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
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            WishlistSeeder::class,
            WishlistItemSeeder::class,
        ]);

        // Re-enable foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
