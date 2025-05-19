<?php

namespace Modules\ContentManagement\Database\Seeders;

use Illuminate\Database\Seeder;

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
