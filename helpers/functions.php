<?php
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
        return Str::slugify( $text, $divider );
    }
}