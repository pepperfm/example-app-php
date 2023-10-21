<?php

/**
 * @var \App\App\Router$router
 * @var ?\App\Models\User $user
 */
$user = \App\App\App::get('user');

$router->get('/login', 'AuthController@showLoginForm');
$router->post('/login', 'AuthController@login');
$router->get('/logout', 'AuthController@logout');

$router->get('/', 'TaskController@index');
$router->get('/tasks', 'TaskController@index');

$router->get('/tasks/create', 'TaskController@create');
$router->post('/tasks/store', 'TaskController@store');

if ($user?->isAdmin) {
    $router->get('/tasks/edit', 'TaskController@edit');
    $router->post('/tasks/edit', 'TaskController@update');

    $router->get('/tasks/delete', 'TaskController@delete');
}
