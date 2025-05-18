<?php

namespace Modules\AnalyticsAndReporting\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\AnalyticsAndReporting\app\Models\Report;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        $reportTypes = ['sales', 'inventory', 'user_activity', 'marketing', 'financial'];

        return [
            'name' => $this->faker->words(3, true) . ' Report',
            'type' => $this->faker->randomElement($reportTypes),
            'body' => json_encode([
                'summary' => $this->faker->paragraph(),
                'data' => [
                    'labels' => [$this->faker->word(), $this->faker->word(), $this->faker->word()],
                    'values' => [$this->faker->numberBetween(10, 100), $this->faker->numberBetween(10, 100), $this->faker->numberBetween(10, 100)],
                ],
                'period' => $this->faker->dateTimeThisYear()->format('Y-m-d') . ' - ' . $this->faker->dateTimeThisYear()->format('Y-m-d'),
            ]),
            'exported_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
