<?php

use Slendie\Framework\Environment\Environment;
use Slendie\Framework\View\Loader;
use Slendie\Framework\View\Transpiler;

include_once( 'bootstrap/app.php' );

/* Test Environment */
$env = Environment::getInstance();
$env->load();
$vars = $env->all();

/* Test Loader */
$loader = new Loader( 'view', 'packages/Slendie/Framework/tests/views', 'tpl.php' );
$loader->parse();
$sections = $loader->getSections();

file_put_contents('loader.html', $loader->getContent());

/* Test View Transpiler */
$content = file_get_contents('packages/slendie/framework/tests/views/transpiler_route.tpl.php');

/*$transpiler = new Transpiler( $content );
$matches = $transpiler->parse();
$transpiled = $transpiler->getContent();*/

echo Transpiler::ROUTE_PATTERN . PHP_EOL;

preg_match_all( Transpiler::ROUTE_PATTERN, $content, $matches );

var_dump($matches);

/*echo "Transpiled:\n";
echo $transpiled;*/

// dd( $vars );