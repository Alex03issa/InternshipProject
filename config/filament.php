<?php

return [

    'panels' => [
        'admin' => [
            'path' => 'admin',
            'middleware' => ['web', 'auth'],
            'auth' => [
                'guard' => 'web',
                'login' => '/login', 
            ],
        ],
        'user' => [
            'path' => 'user',
            'middleware' => ['web', 'auth'],
            'auth' => [
                'guard' => 'web',
                'login' => '/login', 
            ],
        ],
    ],

    'auth' => [
        'logout_redirect' => '/login', 
    ],
];

