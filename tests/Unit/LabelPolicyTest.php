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
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $label = Label::factory()->create();

        $policy = new LabelPolicy();
        $this->assertTrue($policy->delete($user, $label));
    }
}
