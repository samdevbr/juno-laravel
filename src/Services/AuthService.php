<?php

namespace Juno\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function isAuthorized()
    {
        $session = Session::get('juno--token');
        $expirationTs = (int)Session::get('juno--token.expires_at');

        return !is_null($session) && time() < $expirationTs;
    }

    public function getToken()
    {
        return Session::get('juno--token');
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

        Session::set('juno--token', $token);
        Session::set('juno--token.expires_at', $expirationTs);

        return true;
    }
}
