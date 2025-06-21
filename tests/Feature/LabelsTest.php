<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Task;
use App\Models\User;
use App\Models\Label;

class LabelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_example(): void
    {
        $this->assertTrue(true);
    }

    public function testCannot_delete_label_if_attached_to_task(): void
    {
        $user  = User::factory()->create();
        $label = Label::factory()->create();
        $task  = Task::factory()->create();
        $task->labels()->attach($label->id);

        $this->actingAs($user)
             ->delete(route('labels.destroy', $label))
             ->assertRedirect(route('labels.index'))
             ->assertSessionHas('flash_notification.0.message', 'Не удалось удалить метку');

        $this->assertDatabaseHas('labels', ['id' => $label->id]);
    }
}