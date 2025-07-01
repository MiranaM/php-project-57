<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testStatusCanBeCreated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => 'In Progress',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'In Progress']);
    }

    public function testStatusCanBeUpdated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => 'Completed',
        ]);

        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Completed']);
    }

    public function testStatusCanBeDeleted()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function testStatusCannotBeDeletedIfUsedInTask()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create(['status_id' => $status->id]);

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertStatus(302);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('flash_notification.0.message', 'Не удалось удалить статус');
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testGuestCannotCreateStatus()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'Unauthorized Status',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('task_statuses', ['name' => 'Unauthorized Status']);
    }

    public function testValidationErrorsOnCreateStatus()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function testGuestCannotDeleteStatus()
    {
        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function testStatusUpdateValidationFails()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => '',
        ]);
        $response->assertSessionHasErrors(['name']);
    }
}
