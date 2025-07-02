<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelsPage(): void
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
    }

    public function testLabelSeed(): void
    {
        $this->seed();
        $this->assertDatabaseHas('labels', [
            'name' => 'ошибка',
        ]);
    }

    public function testLabelCanBeCreated()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('labels.store'), [
            'name' => 'Bug',
            'description' => 'Test Description',
        ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', [
            'name' => 'Bug',
            'description' => 'Test Description',
        ]);
    }

    public function testValidationErrorsOnCreateLabel()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('labels.store'), [
            'name' => '',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function testLabelCanBeUpdated()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $response = $this->patch(route('labels.update', $label), [
            'name' => 'Feature',
            'description' => 'Updated Description',
        ]);

        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseHas('labels', [
            'name' => 'Feature',
            'description' => 'Updated Description',
        ]);
    }

    public function testLabelUpdateValidationFails()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $response = $this->patch(route('labels.update', $label), [
            'name' => '',
        ]);
        $response->assertSessionHasErrors(['name']);
    }

    public function testLabelCanBeDeleted()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();
        $response = $this->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('labels.index'));
        $this->assertDatabaseMissing('labels', ['id' => $label->id]);
    }

    public function testLabelCannotBeDeletedIfAttachedToTask()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();
        /** @var \App\Models\Task $task */
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

    public function testGuestCannotDeleteLabel()
    {
        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $response = $this->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}
