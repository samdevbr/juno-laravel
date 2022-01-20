<?php

namespace Juno\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    public function isAuthorized()
    {
        $session = session()->get('juno--token');
        $expirationTs = (int)session()->get('juno--token-expires_at');

        return !is_null($session) && time() < $expirationTs;
    }

    public function getToken()
    {
        return session()->get('juno--token');
    }

    public function authorize()
    {
        /** @var \Illuminate\Http\Client\PendingRequest */
        $request = Http::junoAuth();

        $response = $request
            ->asForm()
            ->post('/oauth/token', ['grant_type' => 'client_credentials']);

        $token = $response->json('access_token');
        $expiresIn = $response->json('expires_in');

        $expirationTs = time() + $expiresIn;

        session()->put('juno--token', $token);
        session()->put('juno--token-expires_at', $expirationTs);

        return true;
    }
}
