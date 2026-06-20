<?php

// ==============================
// 🔐 AUTH
// ==============================

$router->get('/', 'Auth\\Controllers\\AuthController@index');
$router->get('/login', 'Auth\\Controllers\\AuthController@index');
$router->post('/login', 'Auth\\Controllers\\AuthController@login');

$router->get('/logout', 'Auth\\Controllers\\AuthController@logout', ['auth']);


// ==============================
// 📊 DASHBOARD
// ==============================

$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index', ['auth']);


// ==============================
// 👤 USERS
// ==============================

$router->get('/users', 'Users\\Controllers\\UsersController@index', ['auth', 'users.view']);
$router->get('/users/create', 'Users\\Controllers\\UsersController@create', ['auth', 'users.create']);
$router->post('/users/store', 'Users\\Controllers\\UsersController@store', ['auth', 'users.create']);

$router->get('/users/edit', 'Users\\Controllers\\UsersController@edit', ['auth', 'users.edit']);
$router->post('/users/update', 'Users\\Controllers\\UsersController@update', ['auth', 'users.edit']);

$router->post('/users/delete', 'Users\\Controllers\\UsersController@delete', ['auth', 'users.delete']);
$router->post('/users/restore', 'Users\\Controllers\\UsersController@restore', ['auth', 'users.restore']);
$router->post('/users/toggle', 'Users\\Controllers\\UsersController@toggle', ['auth', 'users.edit']);

$router->post('/users/check-username', 'Users\\Controllers\\UsersController@checkUsername', ['auth']);


// ==============================
// 🏢 SUPPLIERS
// ==============================

$router->get('/suppliers', 'Suppliers\\Controllers\\SupplierController@index', ['auth', 'proveedores.view']);
$router->get('/suppliers/create', 'Suppliers\\Controllers\\SupplierController@create', ['auth', 'proveedores.create']);
$router->get('/suppliers/edit', 'Suppliers\\Controllers\\SupplierController@edit', ['auth', 'proveedores.edit']);

$router->post('/suppliers/store', 'Suppliers\\Controllers\\SupplierController@store', ['auth', 'proveedores.create']);
$router->post('/suppliers/update', 'Suppliers\\Controllers\\SupplierController@update', ['auth', 'proveedores.edit']);
$router->post('/suppliers/delete', 'Suppliers\\Controllers\\SupplierController@delete', ['auth', 'proveedores.delete']);
$router->post('/suppliers/restore', 'Suppliers\\Controllers\\SupplierController@restore', ['auth', 'proveedores.restore']);
$router->post('/suppliers/toggle', 'Suppliers\\Controllers\\SupplierController@toggle', ['auth', 'proveedores.edit']);

$router->get('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit', ['auth']);
$router->post('/suppliers/check-nit', 'Suppliers\\Controllers\\SupplierController@checkNit', ['auth']);


// ==============================
// 🧵 FABRIC TYPES
// ==============================

$router->get('/fabric-types', 'FabricTypes\\Controllers\\FabricTypeController@index', ['auth', 'fabric_types.view']);
$router->post('/fabric-types/store', 'FabricTypes\\Controllers\\FabricTypeController@store', ['auth', 'fabric_types.create']);
$router->get('/fabric-types/edit', 'FabricTypes\\Controllers\\FabricTypeController@edit', ['auth', 'fabric_types.edit']);
$router->post('/fabric-types/update', 'FabricTypes\\Controllers\\FabricTypeController@update', ['auth', 'fabric_types.edit']);
$router->post('/fabric-types/delete', 'FabricTypes\\Controllers\\FabricTypeController@delete', ['auth', 'fabric_types.delete']);
$router->post('/fabric-types/restore', 'FabricTypes\\Controllers\\FabricTypeController@restore', ['auth', 'fabric_types.restore']);
$router->post('/fabric-types/toggle', 'FabricTypes\\Controllers\\FabricTypeController@toggle', ['auth', 'fabric_types.edit']);


// ==============================
//  COLORS
// ==============================

$router->get('/fabric-colors', 'Colors\\Controllers\\ColorController@index', ['auth', 'fabric_colors.view']);
$router->post('/fabric-colors/store', 'Colors\\Controllers\\ColorController@store', ['auth', 'fabric_colors.create']);
$router->post('/fabric-colors/update', 'Colors\\Controllers\\ColorController@update', ['auth', 'fabric_colors.edit']);
$router->post('/fabric-colors/delete', 'Colors\\Controllers\\ColorController@delete', ['auth', 'fabric_colors.delete']);
$router->post('/fabric-colors/restore', 'Colors\\Controllers\\ColorController@restore', ['auth', 'fabric_colors.restore']);
$router->post('/fabric-colors/toggle', 'Colors\\Controllers\\ColorController@toggle', ['auth', 'fabric_colors.edit']);

// ==============================
// 🏬 WAREHOUSES
// ==============================

$router->get('/warehouses', 'Warehouses\\Controllers\\WarehouseController@index', ['auth', 'warehouses.view']);
$router->post('/warehouses/store', 'Warehouses\\Controllers\\WarehouseController@store', ['auth', 'warehouses.create']);
$router->post('/warehouses/update', 'Warehouses\\Controllers\\WarehouseController@update', ['auth', 'warehouses.edit']);
$router->post('/warehouses/delete', 'Warehouses\\Controllers\\WarehouseController@delete', ['auth', 'warehouses.delete']);
$router->post('/warehouses/restore', 'Warehouses\\Controllers\\WarehouseController@restore', ['auth', 'warehouses.restore']);
$router->post('/warehouses/toggle', 'Warehouses\\Controllers\\WarehouseController@toggle', ['auth', 'warehouses.edit']);

// ==============================
// 🧵 ROLLS
// ==============================

$router->get('/rolls', 'Products\\Controllers\\RollController@index', ['auth', 'products.view']);
$router->post('/rolls/store', 'Products\\Controllers\\RollController@store', ['auth', 'products.create']);


// ==============================
// ⚡ API / USERS
// ==============================

$router->post('/api/users/check-username', 'Users\\Controllers\\UsersController@checkUsername', ['auth']);