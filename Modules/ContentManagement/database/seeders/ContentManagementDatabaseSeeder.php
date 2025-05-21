<?php

namespace Modules\ContentManagement\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContentManagementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            MediaSeeder::class,
            PageSeeder::class,
            BlogSeeder::class,
        ]);


    }
}
