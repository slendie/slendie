<?php

use Slendie\Framework\Routing\Route;

// -- Main
Route::get(['set' => '/', 'as' => 'home'], 'AppController@index');

// // -- Test
Route::get('/test', function() {
    echo "<code><pre>Test route is working";
    echo "</pre></code>";
});
