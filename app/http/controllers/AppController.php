<?php
namespace App\Http\Controllers;

use App\Controller;
use App\Models\Card;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\View\Template;

class AppController extends Controller
{
    public function index()
    {
        $cards = Card::all();

        return view('index', compact('cards'));
    }
    public function about()
    {
        return view('about');
    }
    public function contact()
    {
        $view = new Template();
        return $view->render('contact');
        // return view('contact');
    }
    public function blog()
    {
        return view('blog');
    }
}