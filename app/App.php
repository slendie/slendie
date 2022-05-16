<?php
namespace App;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Routing\Router;

final class App
{
    private static $instance = NULL;
    public $request = NULL;

    private function __construct()
    {
        // Catch Request
        $this->request = Request::getInstance();
    }

    public static function getInstance()
    {
        if ( is_null(self::$instance) ) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function run() {
        Router::resolve();
    }
}