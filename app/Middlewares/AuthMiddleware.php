<?php
namespace App\Middlewares;

use App\Middleware;
use Slendie\Framework\Routing\Router;

class AuthMiddleware extends Middleware
{
    public static function up()
    {
        
        return true;
    }

    public static function down()
    {
        return true;
    }
}