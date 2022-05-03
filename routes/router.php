<?php

use Slendie\Framework\Routing\Route;

// -- Main
Route::get(['set' => '/about', 'as' => 'about'], 'AppController@about');
Route::get(['set' => '/contact', 'as' => 'contact'], 'AppController@contact');
Route::get(['set' => '/blog', 'as' => 'blog'], 'AppController@blog');
Route::get(['set' => '/admin', 'as' => 'admin'], 'Admin\AdminController@index');
Route::get(['set' => '/', 'as' => 'home'], 'AppController@index');

Route::get(['set' => '/tasks', 'as' => 'tasks.index'], 'Admin\TaskController@index');
Route::get(['set' => '/tasks/create', 'as' => 'tasks.create'], 'Admin\TaskController@create');
Route::post(['set' => '/tasks/store', 'as' => 'tasks.store'], 'Admin\TaskController@store');
Route::get(['set' => '/tasks/{id}/delete', 'as' => 'tasks.delete'], 'Admin\TaskController@delete');

// // -- Test
Route::get('/test', function() {
    echo "<code><pre>Test route is working";
    echo "</pre></code>";
});
