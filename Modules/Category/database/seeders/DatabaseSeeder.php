<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $this->call([
            CollectionSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductCollectionSeeder::class,
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
