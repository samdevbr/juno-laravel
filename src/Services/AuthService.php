<?php

namespace Juno\Services;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class AuthService
{
    public function isAuthorized()
    {
        return Cache::tags('juno')->has('token');
    }

    public function getToken()
    {
        return Cache::tags('juno')->get('token');
    }

    public function authorize()
    {
        /** @var \Illuminate\Http\Client\PendingRequest */
        $request = Http::junoAuth();

        $response = $request
            ->asForm()
            ->post('/oauth/token', ['grant_type' => 'client_credentials']);

        $response->throwIf($response->failed());

        Cache::tags('juno')
            ->put(
                'token',
                $response['access_token'],
                now()->addSeconds($response['expires_in'])
            );

        return true;
    }
}
