<?php
namespace App\Http\Controllers;

use App\Controller;

class AppController extends Controller
{
    public function index()
    {
        $this->app->view('index');
    }
}