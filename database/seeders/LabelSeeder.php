<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Label;

class LabelSeeder extends Seeder
{
    public function run()
    {
        $labels = [
            [
                'name'        => 'ошибка',
                'description' => 'Какая-то ошибка в коде или проблема с функциональностью',
            ],
            [
                'name'        => 'документация',
                'description' => 'Задача, которая касается документации',
            ],
            [
                'name'        => 'дубликат',
                'description' => 'Повтор другой задачи',
            ],
            [
                'name'        => 'доработка',
                'description' => 'Новая фича, которую нужно запилить',
            ],
        ];

        foreach ($labels as $attrs) {
            Label::firstOrCreate(
                ['name' => $attrs['name']],
                ['description' => $attrs['description']]
            );
        }
    }
}