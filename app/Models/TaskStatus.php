<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    // Разрешаем массовое заполнение поля name
    protected $fillable = ['name'];
}