<?php

return [

    'paths' => ['api/*'],

    'allowed_methods' => ['GET'],

    // Add your Astro dev + production URLs here
    'allowed_origins' => [
        'http://localhost:4321',
        'https://yourastrosite.com',
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => false,

];
