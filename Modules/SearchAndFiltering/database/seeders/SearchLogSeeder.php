<?php

namespace Modules\SearchAndFiltering\database\seeders;

use Illuminate\Database\Seeder;
use Modules\SearchAndFiltering\app\Models\SearchLog;
use Modules\Authorization\app\Models\User;

class SearchLogSeeder extends Seeder
{
    public function run(): void
    {
        // Get actual user IDs from database
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            $this->command->warn('No users found, skipping search log seeding');
            return;
        }

        // Create 3-10 search logs per user
        foreach ($userIds as $userId) {
            $count = rand(3, 10);
            SearchLog::factory()->count($count)->create([
                'user_id' => $userId
            ]);
        }
    }
}