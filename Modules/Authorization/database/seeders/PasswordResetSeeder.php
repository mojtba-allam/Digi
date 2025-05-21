<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\PasswordReset;

class PasswordResetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        PasswordReset::factory()->count(10)->create();
    }
}
