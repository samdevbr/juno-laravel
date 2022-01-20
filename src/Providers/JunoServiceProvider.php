<?php

namespace Juno\Providers;

use Juno\Support\Services\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class JunoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/juno.php' => config_path('juno.php')
        ], 'juno-config');

        $this->mergeConfigFrom(__DIR__ . '/../config/juno.php', 'juno');

        $clientId = Config::get('juno.api.client_id');
        $clientSecret = Config::get('juno.api.client_secret');
        $privateToken = Config::get('juno.api.private_token');

        $authBaseUrl = Config::get('juno.api.environment') === 'sandbox' ?
            'https://sandbox.boletobancario.com/authorization-server' :
            'https://api.juno.com.br/authorization-server';

        $resourceBaseUrl = Config::get('juno.api.environment') === 'sandbox' ?
            'https://sandbox.boletobancario.com/api-integration' :
            'https://api.juno.com.br';

        Http::macro(
            'junoAuth',
            fn () => Http::withBasicAuth($clientId, $clientSecret)
                ->withHeaders([
                    'X-Api-Version' => Config::get('juno.api.version')
                ])
                ->baseUrl($authBaseUrl)
        );

        Http::macro(
            'juno',
            fn () => function () use ($privateToken, $resourceBaseUrl) {
                if (!Auth::isAuthorized()) {
                    Auth::authorize();
                }

                Http::withToken(Auth::getToken())->withHeaders([
                    'X-Resource-Token' => $privateToken,
                    'X-Api-Version' => Config::get('juno.api.version')
                ])->baseUrl($resourceBaseUrl);
            }
        );
    }
}
