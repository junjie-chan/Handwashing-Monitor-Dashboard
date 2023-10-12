<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');
$routes->get('/login', 'Login::index');
$routes->get('/home', 'Login::index');
$routes->get('/load_data', 'Login::load_data');
$routes->get('/user_login', 'Login::login');
$routes->post('/check', 'Login::check');
$routes->get('/logout', 'Login::logout');
$routes->get('/summary', 'Summary::index');
$routes->get('/dashboard2', 'Dashboard2::index');
$routes->get('/dashboard', 'Dashboard::index');

$routes->get('/updates', 'DataManager::index');
$routes->get('/updates/stream', 'DataManager::stream');
