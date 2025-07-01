<?php

namespace Tests\Unit;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskStatusCanBeCreated()
    {
        $status = TaskStatus::factory()->create([
            'name' => 'Testing status'
        ]);

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'Testing status'
        ]);
    }
}
