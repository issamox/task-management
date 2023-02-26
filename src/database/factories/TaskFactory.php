<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
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
            'title' => fake()->name(),
            'isCompleted' => fake()->randomElement([true,false]),
            'user_id' => User::all()->random(),
            'assign_to' => User::all()->random(),
            'project_id' => Project::all()->random(),
        ];
    }
}
