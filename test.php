<?php

use Slendie\Framework\Environment\Environment;

include_once( 'bootstrap/app.php' );

$env = Environment::getInstance();
$env->load();
$vars = $env->all();

// dd( $vars );