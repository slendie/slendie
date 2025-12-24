<?php

declare(strict_types=1);

namespace App;

final class App
{
    public function __construct()
    {
        // Application initialization code can go here
    }

    public function bootstrap()
    {
        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

             // Load environment variables
        $envPath = BASE_PATH . '/.env';
        if (!file_exists($envPath)) {
            $envPath = BASE_PATH . '/.env.example';
        }
        \Slendie\Framework\Env::load($envPath);

        // Load app configuration
        $app = require BASE_PATH . '/config/app.php';
        date_default_timezone_set($app['timezone']);
        ini_set('display_errors', $app['debug'] ? '1' : '0');
    }

    public function run()
    {
        $routes = require BASE_PATH . '/config/routes.php';
        $router = new \Slendie\Framework\Router($routes);
        $router->dispatch();
    }
}
