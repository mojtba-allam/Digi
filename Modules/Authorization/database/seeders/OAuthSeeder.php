<?php

namespace Modules\Authorization\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Authorization\app\Models\OAuth;
use Modules\Authorization\app\Models\User;

class OAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Get actual user IDs from database
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping OAuth seeding');
            return;
        }

        foreach ($userIds as $userId) {
            // Create 0-2 OAuth connections per user
            $count = rand(0, 2);
            if ($count > 0) {
                OAuth::factory()->count($count)->create([
                    'user_id' => $userId
                ]);
            }
        }
    }
}
