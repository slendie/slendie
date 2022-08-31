<?php
use Slendie\Framework\Routing\MiddlewareCollection;

MiddlewareCollection::register('auth', 'App\Middlewares\AuthMiddleware');