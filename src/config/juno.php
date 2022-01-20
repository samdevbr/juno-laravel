<?php

return [
    'api' => [
        'client_id' => env('JUNO_CLIENT_ID', null),
        'client_secret' => env('JUNO_CLIENT_SECRET', null),
        'private_token' => env('JUNO_PRIVATE_TOKEN', null),
        'public_token' => env('JUNO_PUBLIC_TOKEN', null),
        'version' => env('JUNO_API_VERSION', 2)
    ],
];
