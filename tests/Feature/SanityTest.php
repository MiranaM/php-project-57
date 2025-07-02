<?php

namespace Tests\Feature;

use Tests\TestCase;

class SanityTest extends TestCase
{
    public function testMainPageIsAccessible()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
