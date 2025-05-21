<?php

namespace Modules\SearchAndFiltering\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Authorization\app\Models\User;
use Modules\SearchAndFiltering\app\Models\SearchLog;

class SearchLogFactory extends Factory
{
    protected $model = SearchLog::class;

    public function definition(): array
    {
        return [
            'query' => $this->faker->words(mt_rand(1, 4), true),
            'user_id' => User::factory(), // Create a new user or use an existing one
        ];
    }
}
