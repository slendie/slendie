<?php
namespace App;

use Slendie\Framework\Routing\Request;
// use Slendie\Framework\Routing\Route;
use Slendie\Framework\Routing\Router;
use Slendie\Framework\View\View;

final class App
{
    private static $instance = NULL;
    public $view = NULL;
    public $request = NULL;

    private function __construct()
    {
        // Create $view
        $this->view = new View( NULL, 'tpl.php' );
        $this->view->fromEnv( SITE_FOLDER, '.env' );

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

    public function view( $template, $data = [] ) {
        echo $this->view->view($template, $data);
    }

    public function run() {
        // Route::resolve( $this->request );
        Router::resolve();
    }
}