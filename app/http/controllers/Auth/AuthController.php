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
            // return redirect('login');
        }

        return redirect('home');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function create()
    {
        $request = Request::getInstance();

        $user_exists = Auth::userExists( $request->email );

        if ( $user_exists ) {
            Flash::error('Já existe um utilizador com o email indicado.');
            return view('auth.register');
        }
        if ( $request->password != $request->password_confirmation ) {
            Flash::error('A password e a confirmação da password não coincidem.');
            return view('auth.register');
        }

        $user = new User();
        $user->email    = $request->email;
        $user->password = $request->password;

        $user->save();

        return redirect('auth.login');
    }
}