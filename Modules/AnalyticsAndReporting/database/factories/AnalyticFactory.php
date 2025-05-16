<?php

namespace Modules\AnalyticsAndReporting\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AnalyticsAndReporting\app\Models\Analytic;

class AnalyticFactory extends Factory
{
    protected $model = Analytic::class;

    public function definition(): array
    {
        $metrics = ['page_views', 'clicks', 'conversions', 'bounce_rate', 'session_duration', 'unique_visitors'];

        return [
            'metric' => $this->faker->randomElement($metrics),
            'value' => $this->faker->randomElement([
                $this->faker->numberBetween(100, 10000),  // For page_views, clicks, etc.
                $this->faker->randomFloat(2, 0, 100) . '%', // For percentages like bounce_rate
                $this->faker->randomFloat(2, 1, 10) . ' min', // For durations
            ]),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
