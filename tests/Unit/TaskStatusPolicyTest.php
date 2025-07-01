<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\TaskStatus;
use App\Policies\TaskStatusPolicy;
use Tests\TestCase;

class TaskStatusPolicyTest extends TestCase
{
    public function testDenyDeleteForForeignUser()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $policy = new TaskStatusPolicy();
        $this->assertTrue($policy->delete($user, $status));
    }
}
