<?php
use Slendie\Framework\Session\Session;
use Slendie\Tools\Str;

if ( !function_exists('startsWith') ) {
    function startsWith( $test, $subject ) {
        return Str::startsWith( $test, $subject );
    }
}

if ( !function_exists('endsWith') ) {
    function endsWith( $test, $subject ) {
        return Str::endsWith( $test, $subject );
    }
}

if ( !function_exists('randomStr')) {
    function randomStr($length = 8, $params = ['lower', 'capital', 'number', 'symbol', 'simsym']) 
    {
        return Str::randomStr( $length, $params );
    }    
}

if ( !function_exists('dd') ) {
    function dd( ...$variables ) {
        echo '<pre>';
        foreach( $variables as $var )
        var_dump( $var );
        echo '</pre>';
        die();
    }
}

if ( !function_exists('dc') ) {
    function dc( ...$variables ) {
        echo '<pre>';
        foreach( $variables as $var )
        var_dump( $var );
        echo '</pre>';
    }
}

if ( !function_exists('slugify') ) {
    function slugify($text, string $divider = '-')
    {
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
        return 'n-a';
        }

        return $text;
    }    
}

if ( !function_exists('auth') ) {
    function auth() 
    {
        return Session::has( 'logged_user' );
    }
}