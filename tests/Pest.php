<?php
define('PHPUNIT_TEST', true);
require_once __DIR__ . '/../vendor/autoload.php';

use Slendie\Framework\Autoloader;
use Slendie\Framework\Env;

// Registra o autoloader customizado
Autoloader::register();

Env::set('APP_NAME', 'Test App');
Env::set('DB_CONNECTION', 'sqlite');
Env::set('DB_DATABASE', ':memory:');
Env::set('TIMEZONE', 'UTC');

date_default_timezone_set('UTC');

require_once __DIR__ . '/../migrate.php';
