<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(1),
            'description' => fake()->realText(300),
            'status' => fake()->randomElement(['in_progress', 'to_do', 'completed']),
            'tag' => fake()->randomElement(['coding', 'writing', 'lab', 'research']),
            'project_id' => \App\Models\Project::factory(),
            'milestone_id' => null
        ];
    }
}
