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
$router->post('/suppliers/update', 'Suppliers\\Controllers\\SupplierController@update');

// 🔥 ACCIONES 
$router->post('/suppliers/delete', 'Suppliers\\Controllers\\SupplierController@delete');
$router->post('/suppliers/restore', 'Suppliers\\Controllers\\SupplierController@restore');
$router->post('/suppliers/toggle', 'Suppliers\\Controllers\\SupplierController@toggle');


// ==============================
// ⚡ SUPPLIERS AJAX
// ==============================

$router->get('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit');

require __DIR__ . '/../Modules/Products/Routes.php';

// ==============================
// TYPES
// ==============================
$router->get('/products/types', 'Products\\Controllers\\FabricTypeController@index');
$router->post('/products/types/store', 'Products\\Controllers\\FabricTypeController@store');
$router->get('/products/types/edit', 'Products\\Controllers\\FabricTypeController@edit');
$router->post('/products/types/update', 'Products\\Controllers\\FabricTypeController@update');
$router->post('/products/types/delete', 'Products\\Controllers\\FabricTypeController@delete');
$router->get('/products/types/restore/{id}', 'Products\\Controllers\\FabricTypeController@restore');
$router->post('/products/types/restore', 'Products\\Controllers\\FabricTypeController@restore');



// ==============================
//  COLORS
// ==============================

$router->get('/products/colors', 'Products\\Controllers\\ColorController@index');
$router->post('/products/colors/store', 'Products\\Controllers\\ColorController@store');
$router->post('/products/colors/update', 'Products\\Controllers\\ColorController@update');
$router->post('/products/colors/delete', 'Products\\Controllers\\ColorController@delete');
$router->post('/products/colors/restore', 'Products\\Controllers\\ColorController@restore');
