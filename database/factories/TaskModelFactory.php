<?php

namespace Database\Factories;

use App\Models\ProjectModel;
use App\Models\User;
use App\Services\TaskStatusService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TaskModel>
 */
class TaskModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => ProjectModel::inRandomOrder()->value('id') ?? ProjectModel::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => fake()->randomElement(TaskStatusService::getStatusList()),
            'finished_at' => fake()->optional()->dateTimeBetween('now', '+1 month'),
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
        ];
    }
}
