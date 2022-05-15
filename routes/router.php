<?php

use Slendie\Framework\Routing\Router;

Router::get('/', 'AppController@index')->name('home');
Router::get('/about', 'AppController@about')->name('about');
Router::get('/contact', 'AppController@contact')->name('contact');
Router::get('/blog', 'AppController@blog')->name('blog');
Router::get('/admin', 'Admin\AdminController@index')->name('admin');

Router::get('/tasks', 'Admin\TaskController@index')->middleware(['auth'])->name('tasks.index');
Router::get('/tasks/create', 'Admin\TaskController@create')->middleware(['auth'])->name('tasks.create');
Router::post('/tasks/create', 'Admin\TaskController@store')->middleware(['auth'])->name('tasks.store');
Router::get('/tasks/{id}/edit', 'Admin\TaskController@edit')->middleware(['auth'])->name('tasks.edit');
Router::post('/tasks/{id}/edit', 'Admin\TaskController@update')->middleware(['auth'])->name('tasks.update');
Router::post('/tasks/{id}/delete', 'Admin\TaskController@delete')->middleware(['auth'])->name('tasks.delete');

// -- Test
Router::get('/test', function() {
    echo "<code><pre>Test route is working";
    echo "</pre></code>";
})->name('test');
