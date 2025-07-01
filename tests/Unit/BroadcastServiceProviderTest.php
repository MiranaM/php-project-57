<?php

namespace Tests\Unit;

use App\Providers\BroadcastServiceProvider;
use Tests\TestCase;

class BroadcastServiceProviderTest extends TestCase
{
    public function testProviderBootsWithoutErrors()
    {
        $provider = new BroadcastServiceProvider(app());
        $this->assertNotNull($provider);
    }

    public function testProviderBoots()
    {
        $provider = new \App\Providers\BroadcastServiceProvider(app());
        $this->assertNotNull($provider);
    }
}
