<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->get('/home', 'Login::index');
$routes->post('/check', 'Login::check');
$routes->get('/summary', 'Summary::index');
$routes->get('/dashboard2', 'Dashboard2::index');
$routes->get('/dashboard', 'Dashboard::index');
