<?php

return [
    'url' => env('OPCACHE_URL', config('app.url')),
    'prefix' => 'opcache-api',
    'verify_ssl' => true,
    'headers' => [],
    'directories' => [
        base_path('app'),
        base_path('bootstrap'),
        base_path('public'),
        base_path('resources'),
        base_path('routes'),
        base_path('storage'),
        base_path('vendor'),
    ],
    'exclude' => [
        'tests',
        'stubs',
        'Dumper'
    ]
];
