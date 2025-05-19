<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\App\Models\Oauth;

class OauthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Oauth::factory()->count(10)->create();
    }
}
