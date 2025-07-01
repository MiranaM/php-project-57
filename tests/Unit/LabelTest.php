<?php

namespace Tests\Unit;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public function testLabelCanBeCreated()
    {
        $label = Label::factory()->create([
            'name' => 'Feature label',
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => 'Feature label'
        ]);
    }
}
