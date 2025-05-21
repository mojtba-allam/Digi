<?php

namespace Modules\Product\database\seeders;

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
            ProductSeeder::class,
            ProductAttributeSeeder::class,
            ProductVariantSeeder::class,
            ProductMediaSeeder::class,
            AttributeVariantSeeder::class,
        ]);


    }
}
