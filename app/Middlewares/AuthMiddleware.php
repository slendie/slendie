<?php
namespace App\Middlewares;

use App\Middleware;
use App\Models\User;
use Slendie\Framework\Routing\Router;
use Slendie\Framework\Session\Session;


class AuthMiddleware extends Middleware
{
    public static function up()
    {
        if ( !auth() ) {
            return false;
            // return redirect('/login');
        } else {
            $user = User::find( Session::get('logged_user') );
            if ( !$user ) {
                return false;
                // return redirect('/login');
            }
        }
        
        return true;
    }

    public static function down()
    {
        return true;
    }

    public static function fail()
    {
        redirect('login');
    }
}