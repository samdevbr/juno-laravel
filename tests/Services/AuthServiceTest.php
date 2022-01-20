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
        $this->assertTrue(session()->has('juno--token'));
        $this->assertTrue(session()->has('juno--token-expires_at'));
        $this->assertStringStartsWith('ey', session()->get('juno--token'));
    }
}
