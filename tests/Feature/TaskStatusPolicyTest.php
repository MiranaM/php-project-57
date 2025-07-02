<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskStatusPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotCreateStatus()
    {
        $response = $this->post(route('task_statuses.store'), [
            'name' => 'Some status',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function testUserCanCreateStatus()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('task_statuses.store'), [
            'name' => 'User status',
        ]);
        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'User status',
        ]);
    }
}
