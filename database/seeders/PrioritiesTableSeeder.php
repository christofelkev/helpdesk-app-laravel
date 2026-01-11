<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Priority;

class PrioritiesTableSeeder extends Seeder
{
    public function run(): void
    {
        $priorities = [
            ['name' => 'Low', 'level' => 1, 'color' => '#28a745', 'response_time_hours' => 48, 'resolution_time_hours' => 168, 'description' => 'Non-urgent issues'],
            ['name' => 'Medium', 'level' => 2, 'color' => '#ffc107', 'response_time_hours' => 24, 'resolution_time_hours' => 72, 'description' => 'Standard issues'],
            ['name' => 'High', 'level' => 3, 'color' => '#fd7e14', 'response_time_hours' => 8, 'resolution_time_hours' => 48, 'description' => 'Important issues affecting work'],
            ['name' => 'Urgent', 'level' => 4, 'color' => '#dc3545', 'response_time_hours' => 2, 'resolution_time_hours' => 24, 'description' => 'Critical issues requiring immediate attention'],
        ];

        foreach ($priorities as $priority) {
            Priority::create($priority);
        }
    }
}
