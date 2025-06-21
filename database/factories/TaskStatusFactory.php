<?php

namespace Database\Factories;

use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskStatusFactory extends Factory
{
    protected $model = TaskStatus::class;

    public function definition()
    {
        return [
            // На всякий случай уникальное имя
            'name' => $this->faker->unique()->word(),
        ];
    }
}