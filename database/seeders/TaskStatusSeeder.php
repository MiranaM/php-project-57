<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    public function run()
    {
        $statuses = [
            'Новый',
            'В работе',
            'На тестировании',
            'Завершён',
        ];

        foreach ($statuses as $name) {
            TaskStatus::firstOrCreate(['name' => $name]);
        }
    }
}