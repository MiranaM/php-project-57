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
}
