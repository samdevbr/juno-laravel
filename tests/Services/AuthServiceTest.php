<?php

namespace Juno\Tests;

use Juno\Support\Services\Auth;

class AuthServiceTest extends TestCase
{
    /**
     * @test
     */
    public function itIsNotAuthorized()
    {
        $this->assertFalse(Auth::isAuthorized());
    }

    /**
     * @test
     */
    public function itCanAuthorizeClient()
    {
        $this->assertTrue(Auth::authorize());
        $this->assertNotNull(Auth::getToken());
        $this->assertStringStartsWith('ey', Auth::getToken());
    }
}
