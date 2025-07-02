<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testTasksPage()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testTaskDetailIsAccessible()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);

        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
        $response->assertSee($task->name);
    }

    public function testTaskCanBeCreated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = TaskStatus::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'New Task',
            'description' => 'Test Description',
            'status_id' => $status->id,
        ]);
        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseHas('tasks', [
            'name' => 'New Task',
            'description' => 'Test Description',
            'status_id' => $status->id,
        ]);
    }

    public function testValidationErrorsOnCreateTask()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('tasks.store'), [
            'name' => '', // пустое имя
        ]);
        $response->assertSessionHasErrors(['name', 'status_id']);
    }

    public function testGuestCannotCreateTask()
    {
        $status = TaskStatus::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'No Auth Task',
            'status_id' => $status->id,
        ]);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('tasks', ['name' => 'No Auth Task']);
    }

    public function testTaskCanBeUpdated()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);
        $newStatus = TaskStatus::factory()->create();

        $response = $this->patch(route('tasks.update', $task), [
            'name' => 'Updated Task',
            'description' => 'Updated Description',
            'status_id' => $newStatus->id,
        ]);
        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseHas('tasks', [
            'name' => 'Updated Task',
            'description' => 'Updated Description',
            'status_id' => $newStatus->id,
        ]);
    }

    public function testTaskCanBeDeleted()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);
        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testTaskCannotBeDeletedByNotOwner()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();

        $status = TaskStatus::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $otherUser->id, 'status_id' => $status->id]);

        $this->actingAs($user);
        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertStatus(302);
        $response->assertRedirect(route('tasks.index', ['page' => 1]));
        $response->assertSessionHas('flash_notification.0.message', 'Нет прав для этого действия');
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }
}
