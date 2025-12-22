<?php

declare(strict_types=1);
// Load Composer autoloader
require_once dirname(__DIR__) . '/vendor/autoload.php';

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Register custom autoloader for controllers and models
Slendie\Framework\Autoloader::register(BASE_PATH);

// Load and bootstrap the application
$app = new App\App();
$app->bootstrap();
$app->run();
