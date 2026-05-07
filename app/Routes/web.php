<?php

// DASHBOARD
$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index');

// HOME (puede ser dashboard o login)
$router->get('/', 'Auth\\Controllers\\AuthController@index');

// LOGIN (mostrar formulario)
$router->get('/login', 'Auth\\Controllers\\AuthController@index');

// PROCESAR LOGIN
$router->post('/auth/login', 'Auth\\Controllers\\AuthController@login');