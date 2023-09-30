<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/summary', 'Summary::index');
$routes->get('/dashboard', 'Dashboard::index');
