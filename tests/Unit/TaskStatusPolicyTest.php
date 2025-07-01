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
        /** @var \App\Models\User $user */
        $user = User::factory()->create();

        /** @var \App\Models\User $user */
        $otherUser = User::factory()->create();

        /** @var \App\Models\TaskStatus $taskStatus */
        $status = TaskStatus::factory()->create();

        $policy = new TaskStatusPolicy();
        $this->assertTrue($policy->delete($user, $status));
    }
}
