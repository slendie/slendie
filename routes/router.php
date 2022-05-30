<?php

use Slendie\Framework\Routing\Router;

Router::get('/', 'AppController@index')->name('home');
Router::get('/about', 'AppController@about')->name('about');
Router::get('/contact', 'AppController@contact')->name('contact');
Router::get('/blog', 'AppController@blog')->name('blog');
Router::get('/admin', 'Admin\AdminController@index')->name('admin');
Router::get('/login', 'Auth\AuthController@login')->name('login');
Router::post('/login', 'Auth\AuthController@signin')->name('signin');

Router::get('/tasks', 'Admin\TaskController@index')->middleware(['auth'])->name('tasks.index');
Router::get('/tasks/create', 'Admin\TaskController@create')->middleware(['auth'])->name('tasks.create');
Router::post('/tasks/create', 'Admin\TaskController@store')->middleware(['auth'])->name('tasks.store');
Router::get('/tasks/{id}/edit', 'Admin\TaskController@edit')->middleware(['auth'])->name('tasks.edit');
Router::post('/tasks/{id}/edit', 'Admin\TaskController@update')->middleware(['auth'])->name('tasks.update');
Router::post('/tasks/{id}/delete', 'Admin\TaskController@delete')->middleware(['auth'])->name('tasks.delete');
Router::get('/tasks/complete', 'Admin\TaskController@complete')->middleware(['auth'])->name('tasks.complete');

Router::get('/cards', 'Admin\CardController@index')->middleware(['auth'])->name('cards.index');
Router::get('/cards/create', 'Admin\CardController@create')->middleware(['auth'])->name('cards.create');
Router::post('/cards/create', 'Admin\CardController@store')->middleware(['auth'])->name('cards.store');
Router::get('/cards/{id}/edit', 'Admin\CardController@edit')->middleware(['auth'])->name('cards.edit');
Router::post('/cards/{id}/edit', 'Admin\CardController@update')->middleware(['auth'])->name('cards.update');
Router::post('/cards/{id}/delete', 'Admin\CardController@delete')->middleware(['auth'])->name('cards.delete');
Router::get('/card/{slug}', 'Admin\CardController@show')->name('cards.show');

Router::get('/users', 'Admin\UserController@index')->middleware(['auth'])->name('users.index');
Router::get('/users/create', 'Admin\UserController@create')->middleware(['auth'])->name('users.create');
Router::post('/users/create', 'Admin\UserController@store')->middleware(['auth'])->name('users.store');
Router::get('/users/{id}/edit', 'Admin\UserController@edit')->middleware(['auth'])->name('users.edit');
Router::post('/users/{id}/edit', 'Admin\UserController@update')->middleware(['auth'])->name('users.update');
Router::post('/users/{id}/delete', 'Admin\UserController@delete')->middleware(['auth'])->name('users.delete');


// -- Test
Router::get('/test', function() {
    echo "<code><pre>Test route is working";
    echo "</pre></code>";
})->name('test');
