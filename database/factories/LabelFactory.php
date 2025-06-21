<?php

namespace Database\Factories;

use App\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    protected $model = Label::class;

    public function definition()
    {
        return [
            'name'        => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
        ];
    }
}