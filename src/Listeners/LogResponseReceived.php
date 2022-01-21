<?php
namespace Juno\Listeners;

use Illuminate\Http\Client\Events\ResponseReceived;
use Illuminate\Support\Facades\Log;

class LogResponseReceived
{
    public function handle(ResponseReceived $event)
    {
        $response = $event->response;

        if ($response->failed() && config('juno.logging', false)) {
            Log::error('request failed', [
                'method' => $event->request->method(),
                'url' => $event->request->url(),
                'headers' => $event->request->headers(),
                'body' => $event->request->body()
            ]);
        }

        $response->throw();
    }
}
