<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Milestone>
 */
class MilestoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_id' => \App\Models\Project::factory(), // Crea automaticamente un progetto se non esiste
            'title' => fake()->word() . ' Review',
            'due_date' => fake()->dateTimeBetween('now', '+6 months'),
            'status' => fake()->boolean(),
        ];
    }
}
