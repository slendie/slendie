<?php
namespace App\Http\Controllers;

use App\Controller;
use Slendie\Framework\Routing\Request;

class AppController extends Controller
{
    public function index()
    {
        $this->app->view('index');
    }
    public function about()
    {
        $this->app->view('about');
    }
    public function contact()
    {
        $this->app->view('contact');
    }
    public function blog()
    {
        $this->app->view('blog');
    }
}