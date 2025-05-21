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


        $this->call([
            CollectionSeeder::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ProductCollectionSeeder::class,
            ProductCategorySeeder::class,
            ProductBrandSeeder::class,
        ]);


    }
}
