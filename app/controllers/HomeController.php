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

        // Get form errors and success message from session
        $formErrors = $_SESSION['form_errors'] ?? [];
        $formSuccess = $_SESSION['form_success'] ?? null;

        // Clear session messages after retrieving them
        unset($_SESSION['form_errors']);
        unset($_SESSION['form_success']);

        $html = $blade->render('home', [
            'app_name' => Env::get('APP_NAME', 'PHP MVC'),
            'year' => date('Y'),
            'form_errors' => $formErrors,
            'form_success' => $formSuccess,
        ]);
        echo $html;
    }
}
