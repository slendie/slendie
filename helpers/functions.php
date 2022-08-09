<?php
use Slendie\Framework\Session\Session;

if ( !function_exists('startsWith') ) {
    function startsWith( $test, $subject ) {
        if ( strlen($test) > strlen($subject) ) {
            return false;
        } else {
            if ( substr( $subject, 0, strlen($test) ) === $test) {
                return true;
            } else {
                return false;
            }
        }
    }
}

if ( !function_exists('endsWith') ) {
    function endsWith( $test, $subject ) {
        if ( strlen($test) > strlen($subject) ) {
            return false;
        } else {
            $len = strlen($test);
            $start = strlen($subject) - $len;
            if ( substr( $subject, $start, $len ) == $test) {
                return true;
            } else {
                return false;
            }
        }
    }
}

if ( !function_exists('randomStr')) {
    function randomStr($length = 8, $params = ['lower', 'capital', 'number', 'symbol', 'simsym']) 
    {
        $low_letters = "abcdefghijklmnopqrstuvwxyz";
        $cap_letters = strtoupper($low_letters);
        $symbols = "!?#$%&-_";
        $simple_symbols = "-_";
        $numbers = "1234567890";
    
        $source = '';
        if ( in_array('lower', $params) ) {
            $source .= $low_letters;
        }
        if ( in_array('capital', $params) ) {
            $source .= $cap_letters;
        }
        if ( in_array('number', $params) ) {
            $source .= $numbers;
        }
    
        if ( in_array('symbol', $params) ) {
            $source .= $symbols;
    
        } elseif ( in_array('simsymb', $params) ) {
            $source .= $simple_symbols;
        }
    
        $max = strlen($source);
        $i = 0;
        $word = "";
    
        while ($i < $length) {
            $num = rand() % $max;
            $char = substr($source, $num, 1);
            $word .= $char;
            $i++;
        }
    
        return $word;
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