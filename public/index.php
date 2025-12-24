<?php

declare(strict_types=1);

require dirname(__DIR__) . '/config/constants.php';

// Load Composer autoloader
require_once BASE_PATH . '/vendor/autoload.php';

// Register custom autoloader for controllers and models
Slendie\Framework\Autoloader::register(BASE_PATH);

// Load and bootstrap the application
$app = new App\App();
$app->bootstrap();
$app->run();
