<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EmailVerificationNotificationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testSendNotificationIfNotVerified()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create(['email_verified_at' => null]);
        $this->actingAs($user);

        $response = $this->post(route('verification.send'));
        $response->assertSessionHasNoErrors();
    }

    public function testVerificationSendRouteAccessible()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post(route('verification.send'));
        $this->assertTrue($response->isRedirection() || $response->isOk());
    }
}
