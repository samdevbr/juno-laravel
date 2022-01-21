<?php
namespace Juno\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Http\Client\Events\ResponseReceived;
use Juno\Listeners\LogResponseReceived;

class JunoEventServiceProvider extends EventServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        ResponseReceived::class => [
            LogResponseReceived::class
        ]
    ];
}
