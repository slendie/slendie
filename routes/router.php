<?php

use Slendie\Framework\Routing\Router;

Router::get('/', 'AppController@index')->name('home');
Router::get('/login', 'Auth\AuthController@login')->name('login');
Router::post('/login', 'Auth\AuthController@signin')->name('signin');

Router::get('/admin', 'Admin\AdminController@index')->middleware(['auth'])->name('admin');

Router::get('/tasks', 'Admin\TaskController@index')->middleware(['auth'])->name('tasks.index');
Router::get('/tasks/create', 'Admin\TaskController@create')->middleware(['auth'])->name('tasks.create');
Router::post('/tasks/create', 'Admin\TaskController@store')->middleware(['auth'])->name('tasks.store');
Router::get('/tasks/{id}/edit', 'Admin\TaskController@edit')->middleware(['auth'])->name('tasks.edit');
Router::post('/tasks/{id}/edit', 'Admin\TaskController@update')->middleware(['auth'])->name('tasks.update');
Router::post('/tasks/{id}/delete', 'Admin\TaskController@delete')->middleware(['auth'])->name('tasks.delete');
Router::get('/tasks/complete', 'Admin\TaskController@complete')->middleware(['auth'])->name('tasks.complete');

// -- Test
Router::get('/test', function() {
    echo "<code><pre>Test route is working";
    echo "</pre></code>";
})->name('test');
