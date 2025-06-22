<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testTasks_page_is_accessible()
    {
        $response = $this->actingAs($this->user)->get(route('tasks.index'));

        $response->assertOk();
    }

    public function testIt_can_filter_tasks_by_status()
    {
        $status = TaskStatus::factory()->create(['name' => 'В работе']);
        $taskWithStatus = Task::factory()->create(['status_id' => $status->id]);
        Task::factory()->create(); // другая задача, другой статус

        $response = $this->actingAs($this->user)->get(route('tasks.index', [
            'filter' => ['status_id' => $status->id]
        ]));

        $response->assertOk()
                 ->assertSee($taskWithStatus->name)
                 ->assertDontSeeText('другая задача');
    }

    public function testIt_can_filter_tasks_by_assignee()
    {
        $assignee = User::factory()->create(['name' => 'Исполнитель']);
        $taskWithAssignee = Task::factory()->create(['assigned_to_id' => $assignee->id]);
        Task::factory()->create(['assigned_to_id' => null]);

        $response = $this->actingAs($this->user)->get(route('tasks.index', [
            'filter' => ['assigned_to_id' => $assignee->id]
        ]));

        $response->assertOk()
                 ->assertSee($taskWithAssignee->name)
                 ->assertDontSeeText('другая задача');
    }

    public function testIt_can_filter_tasks_by_creator()
    {
        $creator = User::factory()->create(['name' => 'Автор']);
        $taskCreatedByCreator = Task::factory()->create(['created_by_id' => $creator->id]);
        Task::factory()->create();

        $response = $this->actingAs($this->user)->get(route('tasks.index', [
            'filter' => ['created_by_id' => $creator->id]
        ]));

        $response->assertOk()
                 ->assertSee($taskCreatedByCreator->name)
                 ->assertDontSeeText('другая задача');
    }

    public function testIt_can_filter_tasks_by_label()
    {
        $label = Label::factory()->create(['name' => 'Баг']);
        $taskWithLabel = Task::factory()->create();
        $taskWithLabel->labels()->attach($label);

        $otherTask = Task::factory()->create();

        $response = $this->actingAs($this->user)->get(route('tasks.index', [
            'filter' => ['labels.id' => $label->id]
        ]));

        $response->assertOk()
                 ->assertSee($taskWithLabel->name)
                 ->assertDontSee($otherTask->name);
    }
}