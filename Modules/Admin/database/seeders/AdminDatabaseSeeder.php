<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $this->call([
            AdminSeeder::class,
        ]);


    }
}
