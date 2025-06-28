<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Label;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $statuses = TaskStatus::all();
        $labels = Label::all();

        if ($users->isEmpty() || $statuses->isEmpty()) {
            $this->command->warn('Пропущен TaskSeeder — нужны Users и Statuses');
            return;
        }

        // Массив примеров имен задач
        $names = [
            'Настроить CI',
            'Исправить баг с формой',
            'Рефакторинг контроллера',
            'Добавить валидацию',
            'Создать миграции',
            'Обновить зависимости',
            'Добавить логирование',
            'Настроить тесты',
            'Проверить безопасность',
            'Сделать деплой',
            'Написать документацию',
            'Сверстать страницу',
            'Добавить фильтры',
            'Интеграция с API',
            'Починить логин',
            'Сделать экспорт CSV',
            'Добавить графики',
            'Миграция на Laravel 11',
            'Переезд на PostgreSQL',
            'Сброс пароля через почту',
        ];

        foreach ($names as $i => $name) {
            $task = new Task([
                'name' => $name,
                'description' => 'Описание задачи #' . ($i + 1),
                'status_id' => $statuses->random()->id,
                'created_by_id' => $users->random()->id,
                'assigned_to_id' => $users->random()->id,
            ]);

            $task->save();

            // Назначаем 0–3 метки
            $task->labels()->sync(
                $labels->random(rand(0, min(3, $labels->count())))->pluck('id')->toArray()
            );
        }
    }
}
