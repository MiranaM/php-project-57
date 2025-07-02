<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Label;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskLabelRelationTest extends TestCase
{
    use RefreshDatabase;

    public function testTaskCanHaveLabels()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'Task with label',
            'status_id' => $status->id,
            'created_by_id' => $user->id,
            'labels' => [$label->id]
        ]);
        $response->assertSessionHasNoErrors()
            ->assertRedirectContains('/tasks');

        $task = Task::where('name', 'Task with label')->first();
        $this->assertTrue($task->labels->contains($label));
    }

    public function testLabelsDisplayedOnTaskPage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create();
        $label = Label::factory()->create();
        $task->labels()->attach($label);

        $response = $this->get(route('tasks.show', $task));
        $response->assertSee($label->name);
    }
}
