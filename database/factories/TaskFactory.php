<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'status_id' => TaskStatus::factory(),
            'created_by_id' => User::factory(),
            'assigned_to_id' => User::factory(),
        ];
    }
}
