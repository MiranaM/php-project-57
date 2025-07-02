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

    public function testStatusesPage()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('task_statuses.index'));
        $response->assertStatus(200);
    }

    public function testStatusCanBeCreated()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => 'In Progress',
        ]);
        $response->assertSessionHasNoErrors()
                 ->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'In Progress']);
    }

    public function testValidationErrorsOnCreateStatus()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => '',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function testStatusCanBeUpdated()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => 'Completed',
        ]);
        $response->assertSessionHasNoErrors()
                 ->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseHas('task_statuses', ['name' => 'Completed']);
    }

    public function testStatusUpdateValidationFails()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->patch(route('task_statuses.update', $status), [
            'name' => '',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function testStatusCanBeDeleted()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertSessionHasNoErrors()
                 ->assertRedirect(route('task_statuses.index'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $status->id]);
    }

    public function testStatusCannotBeDeletedIfUsedInTask()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\TaskStatus $status */
        $status = TaskStatus::factory()->create();
        /** @var \App\Models\Task $task */
        $task = Task::factory()->create(['status_id' => $status->id]);

        $response = $this->delete(route('task_statuses.destroy', $status));
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

    public function testGuestCannotDeleteStatus()
    {
        /** @var \App\Models\TaskStatus $status */
        $status = TaskStatus::factory()->create();

        $response = $this->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }
}
