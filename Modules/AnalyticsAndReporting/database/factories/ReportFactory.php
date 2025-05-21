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
            'body' => $this->faker->paragraph(5) . "\n\n" .
                      $this->faker->paragraph(3) . "\n\n" .
                      "Key Metrics:\n" .
                      "- " . $this->faker->word() . ": " . $this->faker->numberBetween(10, 100) . "\n" .
                      "- " . $this->faker->word() . ": " . $this->faker->numberBetween(10, 100) . "\n" .
                      "- " . $this->faker->word() . ": " . $this->faker->numberBetween(10, 100) . "\n\n" .
                      "Period: " . $this->faker->dateTimeThisYear()->format('Y-m-d') . ' - ' . $this->faker->dateTimeThisYear()->format('Y-m-d'),
            'exported_at' => $this->faker->optional(0.7)->dateTimeBetween('-1 month', 'now'),
        ];
    }
}