<?php

namespace Juno\Tests;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
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
        $this->assertTrue(Auth::isAuthorized());
        $this->assertNotNull(Auth::getToken());
    }

    /**
     * @test
     */
    public function itWillThrowIfRequestFails()
    {
        Config::set('juno.client_id', '<fake client id>');
        Config::set('juno.logging', true);

        $this->expectException(RequestException::class);

        Log::shouldReceive('error')
            ->once()
            ->withSomeOfArgs('request failed');

        Auth::authorize();
    }
}
