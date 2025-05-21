<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\OAuth;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        OAuth::factory()->count(10)->create();
    }
}
