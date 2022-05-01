<?php
namespace App;

use Slendie\Framework\View\View;
use App\App;

class Controller
{
    protected $app;
    protected $view;

    public function __construct()
    {
        $this->app = App::getInstance();
        $this->view = new View();
        $this->view->fromEnv( SITE_FOLDER, '.env' );
        $this->view->setPath( 'resources.views' );
    }
}