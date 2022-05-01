<?php

use Slendie\Framework\Routing\Route;

// -- Main
Route::get(['set' => '/', 'as' => 'home'], 'PackageController@index');

// // -- Test
Route::get('/test', function() {
    echo "<code><pre>";
    echo "</pre></code>";
});
