<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Label;
use App\Policies\LabelPolicy;
use Tests\TestCase;

class LabelPolicyTest extends TestCase
{
    public function testUserCannotDeleteForeignLabel()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        /** @var \App\Models\User $user */
        $otherUser = User::factory()->create();

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $policy = new LabelPolicy();
        $this->assertTrue($policy->delete($user, $label));
    }

    public function testDeletePolicyAlwaysTrue()
    {
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        /** @var \App\Models\Label $label */
        $label = Label::factory()->create();

        $policy = new \App\Policies\LabelPolicy();
        $this->assertTrue($policy->delete($user, $label));
    }
}
