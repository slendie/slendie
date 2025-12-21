<?php
return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => 'App\Controllers\HomeController@index',
        'middlewares' => [],
    ],
    [
        'method' => 'POST',
        'path' => '/contato',
        'handler' => 'App\Controllers\FormController@store',
        'middlewares' => [],
    ],
    [
        'method' => 'GET',
        'path' => '/login',
        'handler' => 'App\Controllers\AuthController@login',
        'middlewares' => [],
        'name' => 'login'
    ],
    [
        'method' => 'POST',
        'path' => '/signin',
        'handler' => 'App\Controllers\AuthController@signin',
        'middlewares' => []
    ],
    [
        'method' => 'POST',
        'path' => '/logout',
        'handler' => 'App\Controllers\AuthController@logout',
        'middlewares' => ['auth'],
        'name' => 'logout'
    ],
];
