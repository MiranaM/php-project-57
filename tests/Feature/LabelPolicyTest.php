<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function testGuestCannotCreateLabel()
    {
        $response = $this->post(route('labels.store'), [
            'name' => 'Guest Label',
        ]);
        $response->assertRedirect(route('login'));
    }

    public function testUserCanCreateLabel()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('labels.store'), [
            'name' => 'User Label',
        ]);
        $response->assertSessionHasNoErrors()
            ->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', [
            'name' => 'User Label',
        ]);
    }
}
