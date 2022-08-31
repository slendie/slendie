<?php
namespace App\Http\Controllers\Admin;

use App\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}