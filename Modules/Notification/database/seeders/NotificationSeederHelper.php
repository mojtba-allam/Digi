<?php

namespace Modules\Notification\database\seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Faker\Factory as Faker;

class NotificationSeederHelper
{
    public static function getUserIds()
    {
        // Check if any users exist
        $userIds = DB::table('users')->pluck('id')->toArray();

        if (empty($userIds)) {
            // No users exist, so we can't proceed with seeding
            // Instead of trying to create users, throw an informative exception
            throw new \Exception('No users found in the database. Please run the user seeder first.');
        }

        return $userIds;
    }
}
