<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function testGuest_can_view_task_index()
    {
        Task::factory()->count(2)->create();

        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }


    public function testGuest_cannot_access_create_store_edit_update_destroy()
    {
        $task = Task::factory()->create();

        $this->get(route('tasks.create'))->assertRedirect(route('login'));
        $this->post(route('tasks.store'), [])->assertRedirect(route('login'));
        $this->get(route('tasks.edit', $task))->assertRedirect(route('login'));
        $this->patch(route('tasks.update', $task), [])->assertRedirect(route('login'));
        $this->delete(route('tasks.destroy', $task))->assertRedirect(route('login'));
    }


    public function testAuth_user_can_create_task()
    {
        $user    = User::factory()->create();
        $status  = TaskStatus::factory()->create();
        $labels  = Label::factory()->count(2)->create();
        $assignee = User::factory()->create();

        $data = [
            'name'           => 'Test Task',
            'description'    => 'Описание',
            'status_id'      => $status->id,
            'assigned_to_id' => $assignee->id,
            'labels'         => $labels->pluck('id')->toArray(),
        ];

        $this->actingAs($user)
             ->post(route('tasks.store'), $data)
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('tasks', [
            'name'           => 'Test Task',
            'created_by_id'  => $user->id,
            'assigned_to_id' => $assignee->id,
            'status_id'      => $status->id,
        ]);

        $task = Task::first();
        $this->assertEqualsCanonicalizing(
            $labels->pluck('id')->toArray(),
            $task->labels->pluck('id')->toArray()
        );
    }


    public function testAuth_user_can_update_own_task()
    {
        $user    = User::factory()->create();
        $status1 = TaskStatus::factory()->create();
        $status2 = TaskStatus::factory()->create();
        $task    = Task::factory()->create([
            'created_by_id'  => $user->id,
            'status_id'      => $status1->id,
        ]);

        $this->actingAs($user)
             ->patch(route('tasks.update', $task), [
                'name'           => 'Updated',
                'description'    => 'New descr',
                'status_id'      => $status2->id,
                'assigned_to_id' => null,
                'labels'         => [],
             ])
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('tasks', [
            'id'         => $task->id,
            'name'       => 'Updated',
            'status_id'  => $status2->id,
        ]);
    }


    public function testAuth_user_cannot_update_others_task()
    {
        $user  = User::factory()->create();
        $other = User::factory()->create();
        $task  = Task::factory()->create(['created_by_id' => $other->id]);

        $this->actingAs($user)
             ->patch(route('tasks.update', $task), [
                 'name'      => 'Bad',
                 'status_id' => TaskStatus::factory()->create()->id,
             ])
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('flash_notification');
    }


    public function testAuth_user_can_delete_own_task()
    {
        $user = User::factory()->create();
        $task = Task::factory()->create(['created_by_id' => $user->id]);

        $this->actingAs($user)
             ->delete(route('tasks.destroy', $task))
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('flash_notification');

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }


    public function testAuth_user_cannot_delete_others_task()
    {
        $user  = User::factory()->create();
        $other = User::factory()->create();
        $task  = Task::factory()->create(['created_by_id' => $other->id]);

        $this->actingAs($user)
             ->delete(route('tasks.destroy', $task))
             ->assertRedirect(route('tasks.index'))
             ->assertSessionHas('flash_notification');

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }


    public function testValidation_errors_on_store_and_update()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        // Store without required fields
        $this->actingAs($user)
             ->post(route('tasks.store'), [])
             ->assertSessionHasErrors(['name','status_id']);

        // Update without required fields
        $task = Task::factory()->create(['created_by_id' => $user->id]);
        $this->actingAs($user)
             ->patch(route('tasks.update', $task), [])
             ->assertSessionHasErrors(['name','status_id']);
    }

    public function testShow_displays_labels_attached_to_task()
    {
        $user  = User::factory()->create();
        $label = Label::factory()->create(['name' => 'foo']);
        $task  = Task::factory()->create(['created_by_id' => $user->id]);
        $task->labels()->attach($label->id);

        $response = $this->actingAs($user)
                        ->get(route('tasks.show', $task));

        $response->assertStatus(200)
                ->assertSee('foo');
    }
}