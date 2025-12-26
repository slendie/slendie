<?php

declare(strict_types=1);

namespace App\Controllers;

use Slendie\Controllers\Controller;
use Slendie\Framework\Blade;
use Slendie\Framework\Env;

final class HomeController extends Controller
{
    public function index()
    {
        // Blade now reads views_path from config/app.php by default
        // Layout is specified in the view using @extends directive
        $blade = new Blade();

        $html = $blade->render('home', [
            'app_name' => Env::get('APP_NAME', 'PHP MVC'),
            'year' => date('Y'),
        ]);
        echo $html;
    }

    public function docs()
    {
        $blade = new Blade();
        $html = $blade->render('docs');
        echo $html;
    }

    public function legal()
    {
        $blade = new Blade();
        $html = $blade->render('legal');
        echo $html;
    }
}
