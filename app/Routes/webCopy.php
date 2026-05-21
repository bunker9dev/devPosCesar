<?php

// ==============================
// AUTH
// ==============================

// HOME
$router->get('/', 'Auth\\Controllers\\AuthController@index');

// LOGIN
$router->get('/login', 'Auth\\Controllers\\AuthController@index');
$router->post('/auth/login', 'Auth\\Controllers\\AuthController@login');

// LOGOUT
$router->get('/logout', 'Auth\\Controllers\\AuthController@logout');


// ==============================
// DASHBOARD
// ==============================

$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index');


// ==============================
// USERS (ADMIN)
// ==============================

$router->get('/users', 'Users\\Controllers\\UsersController@index');
$router->get('/users/create', 'Users\\Controllers\\UsersController@create');
$router->post('/users/store', 'Users\\Controllers\\UsersController@store');

$router->get('/users/edit', 'Users\\Controllers\\UsersController@edit'); // ?id=1
$router->post('/users/update', 'Users\\Controllers\\UsersController@update');




$router->post('/users/check-username', 'Users\\Controllers\\UsersController@checkUsername');

// ==============================
// AJAX
// ==============================

$router->post('/api/users/check-username', 'Users\\Controllers\\UsersController@checkUsername');


// ==============================
// USER
// ==============================


use App\Modules\Users\Controllers\UserController;
$router->post('/users/toggle', 'Users\\Controllers\\UsersController@toggle');  

