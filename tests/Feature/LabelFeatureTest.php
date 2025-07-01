<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Label;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelCanBeCreated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('labels.store'), [
            'name' => 'Bug',
        ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['name' => 'Bug']);
    }

    public function testLabelCanBeUpdated()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var Label $label */
        $label = Label::factory()->create();

        $response = $this->patch(route('labels.update', $label), [
            'name' => 'Feature',
        ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', ['name' => 'Feature']);
    }

    public function testLabelCanBeDeleted()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var Label $label */
        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelCannotBeDeletedIfAttachedToTask()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var Label $label */
        $label = Label::factory()->create();
        /** @var Task $task */
        $task = Task::factory()->create();
        $task->labels()->attach($label);

        $response = $this->delete(route('labels.destroy', $label));
        $response->assertSessionHas('flash_notification.0.message', 'Не удалось удалить метку');
        $response->assertSessionHas('flash_notification.0.level', 'danger');
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }

    public function testGuestCannotCreateLabel()
    {
        $response = $this->post(route('labels.store'), [
            'name' => 'Unauthorized Label',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertDatabaseMissing('labels', ['name' => 'Unauthorized Label']);
    }

    public function testValidationErrorsOnCreateLabel()
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('labels.store'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors(['name']);
    }
}
