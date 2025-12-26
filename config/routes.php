<?php

declare(strict_types=1);

return [
    [
        'method' => 'GET',
        'path' => '/',
        'handler' => 'App\Controllers\HomeController@index',
        'middlewares' => [],
        'name' => 'home'
    ],
    [
        'method' => 'GET',
        'path' => '/docs',
        'handler' => 'App\Controllers\HomeController@docs',
        'middlewares' => [],
        'name' => 'docs'
    ],
    [
        'method' => 'GET',
        'path' => '/legal',
        'handler' => 'App\Controllers\HomeController@legal',
        'middlewares' => [],
        'name' => 'legal'
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
        'path' => '/login',
        'handler' => 'App\Controllers\AuthController@signin',
        'middlewares' => [],
        'name' => 'login.store'
    ],
    [
        'method' => 'GET',
        'path' => '/register',
        'handler' => 'App\Controllers\AuthController@register',
        'middlewares' => [],
        'name' => 'register'
    ],
    [
        'method' => 'POST',
        'path' => '/register',
        'handler' => 'App\Controllers\AuthController@store',
        'middlewares' => [],
        'name' => 'register.store'
    ],
    [
        'method' => 'GET',
        'path' => '/reset-password',
        'handler' => 'App\Controllers\AuthController@resetPassword',
        'middlewares' => [],
        'name' => 'password.request'
    ],
    [
        'method' => 'POST',
        'path' => '/logout',
        'handler' => 'App\Controllers\AuthController@logout',
        'middlewares' => ['auth'],
        'name' => 'logout'
    ],
];
