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
        } else {
            $user = User::find( Session::get('logged_user') );
            if ( !$user ) {
                return false;
            }
        }
        
        return true;
    }

    public static function down()
    {
        return true;
    }
}