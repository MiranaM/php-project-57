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

    public function testTaskCanBeCreated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'New Task',
            'status_id' => $status->id,
        ]);

        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseHas('tasks', ['name' => 'New Task']);
    }

    public function testTaskCanBeUpdated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);

        $response = $this->patch(route('tasks.update', $task), [
            'name' => 'Updated Task',
            'status_id' => $status->id,
        ]);

        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseHas('tasks', ['name' => 'Updated Task']);
    }

    public function testTaskCanBeDeleted()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);

        $response = $this->delete(route('tasks.destroy', $task));
        $response->assertRedirectContains('/tasks');
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }

    public function testTaskCannotBeDeletedByNotOwner()
    {
        /** @var User $user */
        $user = User::factory()->create();
        /** @var User $otherUser */
        $otherUser = User::factory()->create();

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['created_by_id' => $otherUser->id, 'status_id' => $status->id]);

        $this->actingAs($user);
        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertStatus(302);
        $response->assertRedirect(route('tasks.index', ['page' => 1]));
        $response->assertSessionHas('flash_notification.0.message', 'Нет прав для этого действия');
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }


    public function testTaskListIsAccessible()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testTaskDetailIsAccessible()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['created_by_id' => $user->id, 'status_id' => $status->id]);

        $response = $this->get(route('tasks.show', $task));
        $response->assertOk();
        $response->assertSee($task->name);
    }

    public function testGuestCannotCreateTask()
    {
        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->post(route('tasks.store'), [
            'name' => 'No Auth Task',
            'status_id' => $status->id,
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('tasks', ['name' => 'No Auth Task']);
    }

    public function testValidationErrorsOnCreateTask()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('tasks.store'), [
            'name' => '', // пустое имя
        ]);

        $response->assertSessionHasErrors(['name', 'status_id']);
    }
}
