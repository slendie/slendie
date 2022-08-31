<?php
namespace App\Http\Controllers;

use App\Controller;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\View\Template;

class AppController extends Controller
{
    public function index()
    {
        return view('index');
    }
}