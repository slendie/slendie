<?php
namespace App\Http\Controllers\Admin;

use App\Controller;

class AdminController extends Controller
{
    public function index()
    {
        $this->app->view('admin.index');
    }
}