<?php
namespace App\Http\Controllers\Auth;

use App\Controller;
use App\Models\User;

use Slendie\Framework\Routing\Request;
use Slendie\Framework\Authentication\Auth;
use Slendie\Framework\Session\Flash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signin()
    {
        $request = Request::getInstance();

        $is_auth = Auth::authenticate( $request->email, $request->password );

        if ( !$is_auth ) {
            Flash::error('Utilizador inexistente ou password inválida.');
            return view('auth.login');
        }

        return redirect('home');
    }
}