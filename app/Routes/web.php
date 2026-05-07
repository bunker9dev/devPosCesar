<?php

$router->get('/dashboard', 'Dashboard\\Controllers\\DashboardController@index');

// opcional home
$router->get('/', 'Dashboard\\Controllers\\DashboardController@index');