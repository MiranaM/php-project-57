<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Название задачи');
            $table->text('description')->nullable()->comment('Описание задачи');
            $table->foreignId('status_id')->constrained('task_statuses')
                  ->onDelete('restrict')->comment('Статус задачи');
            $table->foreignId('created_by_id')->constrained('users')
                  ->onDelete('cascade')->comment('Создатель задачи');
            $table->foreignId('assigned_to_id')->nullable()->constrained('users')
                  ->onDelete('set null')->comment('Исполнитель задачи');
            $table->timestamps();
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};