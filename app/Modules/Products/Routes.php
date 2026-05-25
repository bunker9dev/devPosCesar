<?php

// INVENTARIO TEXTIL
$router->get('/rolls', 'Products\\Controllers\\RollController@index');
$router->get('/rolls/create', 'Products\\Controllers\\RollController@create');
$router->post('/rolls/store', 'Products\\Controllers\\RollController@store');
$router->post('/rolls/search', 'Products\\Controllers\\RollController@search');
$router->get('/rolls/search', 'Products\\Controllers\\RollController@search');
$router->get('/rolls/label', 'Products\\Controllers\\RollController@label');

// CATALOGO
$router->get('/products', 'Products\\Controllers\\ProductController@index');
$router->get('/productos', 'Products\\Controllers\\ProductController@index');
$router->get('/products/types', 'Products\\Controllers\\ProductController@types');
$router->get('/products/colors', 'Products\\Controllers\\ProductController@colors');
$router->post('/products/fabric-types/store', 'Products\\Controllers\\ProductController@storeFabricType');
$router->post('/products/colors/store', 'Products\\Controllers\\ProductController@storeColor');

// KARDEX
$router->get('/movements', 'Products\\Controllers\\InventoryMovementController@index');
$router->post('/movements/store', 'Products\\Controllers\\InventoryMovementController@store');

// COMPRAS
$router->get('/purchases', 'Products\\Controllers\\PurchaseController@index');
