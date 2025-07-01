<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCanBeCreatedWithRelations()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $task = Task::factory()->create([
            'name' => 'Test task',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
            'assigned_to_id' => $user->id
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Test task',
            'status_id' => $status->id,
            'created_by_id' => $user->id
        ]);

        $this->assertEquals($status->id, $task->status->id);
        $this->assertEquals($user->id, $task->creator->id);
    }
}
