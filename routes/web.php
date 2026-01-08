<?php

// Home routes
$router->get('/', 'App\Modules\Forum\Controllers\HomeController@index');
$router->get('/home', 'App\Modules\Forum\Controllers\HomeController@index');

// Auth routes
$router->get('/login', 'App\Modules\Auth\Controllers\LoginController@index');
$router->post('/login', 'App\Modules\Auth\Controllers\LoginController@store');
$router->get('/register', 'App\Modules\Auth\Controllers\RegisterController@index');
$router->post('/register', 'App\Modules\Auth\Controllers\RegisterController@store');
$router->post('/logout', 'App\Modules\Auth\Controllers\LogoutController@index');

// Forum routes
$router->get('/forum/{id}', 'App\Modules\Forum\Controllers\ForumController@show');
$router->get('/topic/{id}', 'App\Modules\Forum\Controllers\TopicController@show');
$router->post('/topic/{id}/reply', 'App\Modules\Forum\Controllers\PostController@store');

// Search
$router->get('/search', 'App\Modules\Forum\Controllers\SearchController@index');

// Profile routes
$router->get('/profile', 'App\Modules\User\Controllers\ProfileController@index');
$router->get('/messages', 'App\Modules\Messaging\Controllers\MessageController@index');

// Admin routes
$router->get('/admin', 'App\Modules\Admin\Controllers\DashboardController@index');
