<?php
namespace App;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Routing\Router;
use Slendie\Framework\Database\Connection;
use Slendie\Framework\Environment\Environment;

final class App
{
    private static $instance = NULL;
    public $request = NULL;
    public $conn = NULL;
    public $env = NULL;

    private function __construct()
    {
        // Catch Request
        $this->request = Request::getInstance();
        $this->env = Environment::getInstance();
        $this->env->load();
    }

    public static function getInstance()
    {
        if ( is_null(self::$instance) ) {
            self::$instance = new App();
        }
        return self::$instance;
    }

    public function run() 
    {
        Router::resolve();
    }

    public function db()
    {
        if ( is_null($this->conn) ) {
            $this->conn = Connection::getInstance();
            $this->conn->setOptions( env('DATABASE') );
            $this->conn->connect();
        }
        return $this->conn;
    }
}