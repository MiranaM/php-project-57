<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskLabelRelationTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCanHaveLabels()
    {
        /** @var \App\Models\Task $task */
        $task = Task::factory()->create();

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $task->labels()->attach($label);

        $this->assertTrue($task->labels->contains($label));
        $this->assertDatabaseHas('label_task', [
            'task_id' => $task->id,
            'label_id' => $label->id,
        ]);
    }
}
