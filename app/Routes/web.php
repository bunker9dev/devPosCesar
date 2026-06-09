<?php

// ==============================
// 🔐 AUTH (PÚBLICO)
// ==============================

$router->get('/', 'Auth\\Controllers\\AuthController@index');
$router->get('/login', 'Auth\\Controllers\\AuthController@index');
$router->post('/login', 'Auth\\Controllers\\AuthController@login');

// LOGOUT (PROTEGIDO)
$router->get('/logout', 'Auth\\Controllers\\AuthController@logout', ['auth']);
// LOGOUT (PROTEGIDO)
$router->post('/users/restore', 'Users\\Controllers\\UsersController@restore', ['auth', 'super']);



// ==============================
// 🔐 PERMISOS
// ==============================

// SOLO ADMIN
$router->get('/users', 'Users\\Controllers\\UsersController@index', ['auth', 'admin']);

// SUPER PUEDE RESTAURAR
$router->post('/users/restore', 'Users\\Controllers\\UsersController@restore', ['auth', 'super']);

//ADMIN PUEDE ELIMINAR
$router->post('/users/delete', 'Users\\Controllers\\UsersController@delete', ['auth', 'delete']);


// ==============================
// 📊 DASHBOARD
// ==============================

$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index', ['auth']);


// ==============================
// 👤 USERS
// ==============================

$router->get('/users','Users\\Controllers\\UsersController@index',['auth', 'view']);
$router->get('/users/create', 'Users\\Controllers\\UsersController@create', ['auth', 'edit']);
$router->post('/users/store', 'Users\\Controllers\\UsersController@store', ['auth', 'edit']);

$router->get('/users/edit', 'Users\\Controllers\\UsersController@edit', ['auth', 'edit']);
$router->post('/users/update', 'Users\\Controllers\\UsersController@update', ['auth', 'edit']);

$router->post('/users/delete', 'Users\\Controllers\\UsersController@delete', ['auth', 'delete']);
$router->post('/users/restore', 'Users\\Controllers\\UsersController@restore', ['auth', 'restore']);
$router->post('/users/toggle', 'Users\\Controllers\\UsersController@toggle', ['auth', 'edit']);
$router->post('/users/check-username', 'Users\\Controllers\\UsersController@checkUsername', ['auth']);




// ==============================
// ⚡ USERS AJAX
// ==============================

$router->post('/users/check-username', 'Users\\Controllers\\UsersController@checkUsername', ['auth']);
$router->post('/api/users/check-username', 'Users\\Controllers\\UsersController@checkUsername', ['auth']);


// ==============================
// 🏢 SUPPLIERS
// ==============================

$router->get('/suppliers', 'Suppliers\\Controllers\\SupplierController@index', ['auth']);
$router->get('/suppliers/create', 'Suppliers\\Controllers\\SupplierController@create', ['auth', 'edit']);
$router->get('/suppliers/edit', 'Suppliers\\Controllers\\SupplierController@edit', ['auth', 'edit']);

$router->post('/suppliers/store', 'Suppliers\\Controllers\\SupplierController@store', ['auth', 'edit']);
$router->post('/suppliers/update', 'Suppliers\\Controllers\\SupplierController@update', ['auth', 'edit']);

$router->post('/suppliers/delete', 'Suppliers\\Controllers\\SupplierController@delete', ['auth', 'delete']);
$router->post('/suppliers/restore', 'Suppliers\\Controllers\\SupplierController@restore', ['auth', 'restore']);
$router->post('/suppliers/toggle', 'Suppliers\\Controllers\\SupplierController@toggle', ['auth', 'edit']);

$router->get('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit', ['auth']);


// ==============================
// ⚡ SUPPLIERS AJAX
// ==============================

$router->get('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit', ['auth']);
$router->post('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit', ['auth']);


// ==============================
// 🧵 PRODUCTS - TYPES
// ==============================

$router->get('/products/types', 'Products\\Controllers\\FabricTypeController@index', ['auth']);
$router->post('/products/types/store', 'Products\\Controllers\\FabricTypeController@store', ['auth', 'edit']);
$router->get('/products/types/edit', 'Products\\Controllers\\FabricTypeController@edit', ['auth', 'edit']);
$router->post('/products/types/update', 'Products\\Controllers\\FabricTypeController@update', ['auth', 'edit']);
$router->post('/products/types/delete', 'Products\\Controllers\\FabricTypeController@delete', ['auth', 'delete']);
$router->post('/products/types/restore', 'Products\\Controllers\\FabricTypeController@restore', ['auth', 'restore']);


// ==============================
// 🎨 PRODUCTS - COLORS
// ==============================

$router->get('/products/colors', 'Products\\Controllers\\ColorController@index', ['auth']);
$router->post('/products/colors/store', 'Products\\Controllers\\ColorController@store', ['auth', 'edit']);
$router->post('/products/colors/update', 'Products\\Controllers\\ColorController@update', ['auth', 'edit']);
$router->post('/products/colors/delete', 'Products\\Controllers\\ColorController@delete', ['auth', 'delete']);
$router->post('/products/colors/restore', 'Products\\Controllers\\ColorController@restore', ['auth', 'restore']);


// ==============================
// 🏬 WAREHOUSES
// ==============================

$router->get('/warehouses', 'Products\\Controllers\\WarehouseController@index', ['auth']);
$router->post('/warehouses/store', 'Products\\Controllers\\WarehouseController@store', ['auth', 'edit']);
$router->post('/warehouses/update', 'Products\\Controllers\\WarehouseController@update', ['auth', 'edit']);
$router->post('/warehouses/delete', 'Products\\Controllers\\WarehouseController@delete', ['auth', 'delete']);
$router->post('/warehouses/restore', 'Products\\Controllers\\WarehouseController@restore', ['auth', 'restore']);
$router->post('/warehouses/toggle', 'Products\\Controllers\\WarehouseController@toggle', ['auth', 'edit']);


// ==============================
// 🧵 ROLLS
// ==============================

$router->get('/rolls', 'Products\\Controllers\\RollController@index', ['auth']);
$router->post('/rolls/store', 'Products\\Controllers\\RollController@store', ['auth', 'edit']);