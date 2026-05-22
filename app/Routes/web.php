<?php

// ==============================
// 🔐 AUTH
// ==============================

// HOME / LOGIN
$router->get('/', 'Auth\\Controllers\\AuthController@index');
$router->get('/login', 'Auth\\Controllers\\AuthController@index');
$router->post('/auth/login', 'Auth\\Controllers\\AuthController@login');

// LOGOUT
$router->get('/logout', 'Auth\\Controllers\\AuthController@logout');


// ==============================
// 📊 DASHBOARD
// ==============================

$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index');


// ==============================
// 👤 USERS (ADMIN)
// ==============================

// CRUD
$router->get('/users', 'Users\\Controllers\\UsersController@index');
$router->get('/users/create', 'Users\\Controllers\\UsersController@create');
$router->post('/users/store', 'Users\\Controllers\\UsersController@store');

$router->get('/users/edit', 'Users\\Controllers\\UsersController@edit'); // ?id=1
$router->post('/users/update', 'Users\\Controllers\\UsersController@update');

// 🔥 ACCIONES
$router->post('/users/delete', 'Users\\Controllers\\UsersController@delete');
$router->post('/users/restore', 'Users\\Controllers\\UsersController@restore');
$router->post('/users/toggle', 'Users\\Controllers\\UsersController@toggle');


// ==============================
// ⚡ USERS AJAX
// ==============================

$router->post('/users/check-username', 'Users\\Controllers\\UsersController@checkUsername');
$router->post('/api/users/check-username', 'Users\\Controllers\\UsersController@checkUsername');


// ==============================
// 🏢 SUPPLIERS (PROVEEDORES)
// ==============================

// CRUD
$router->get('/suppliers', 'Suppliers\\Controllers\\SupplierController@index');
$router->get('/suppliers/create', 'Suppliers\\Controllers\\SupplierController@create');
$router->get('/suppliers/edit', 'Suppliers\\Controllers\\SupplierController@edit'); 

$router->post('/suppliers/store', 'Suppliers\\Controllers\\SupplierController@store');

// 🔥 ACCIONES 
$router->post('/suppliers/delete', 'Suppliers\\Controllers\\SupplierController@delete');
$router->post('/suppliers/restore', 'Suppliers\\Controllers\\SupplierController@restore');
$router->post('/suppliers/toggle', 'Suppliers\\Controllers\\SupplierController@toggle');
$router->post('/suppliers/restore', 'Suppliers\\Controllers\\SupplierController@restore');


// ==============================
// ⚡ SUPPLIERS AJAX
// ==============================

$router->get('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit');