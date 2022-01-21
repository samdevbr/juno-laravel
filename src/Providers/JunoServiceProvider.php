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

        $authBaseUrl = Config::get('juno.environment') === 'sandbox' ?
            'https://sandbox.boletobancario.com/authorization-server' :
            'https://api.juno.com.br/authorization-server';

        $resourceBaseUrl = Config::get('juno.environment') === 'sandbox' ?
            'https://sandbox.boletobancario.com/api-integration' :
            'https://api.juno.com.br';

        Http::macro(
            'junoAuth',
            fn () => Http::withBasicAuth(Config::get('juno.client_id'), Config::get('juno.client_secret'))
                ->withHeaders([
                    'X-Api-Version' => Config::get('juno.version')
                ])
                ->baseUrl($authBaseUrl)
        );

        Http::macro(
            'juno',
            fn () => function () use ($resourceBaseUrl) {
                if (!Auth::isAuthorized()) {
                    Auth::authorize();
                }

                Http::withToken(Auth::getToken())->withHeaders([
                    'X-Resource-Token' => Config::get('juno.private_token'),
                    'X-Api-Version' => Config::get('juno.version')
                ])->baseUrl($resourceBaseUrl);
            }
        );
    }
}
