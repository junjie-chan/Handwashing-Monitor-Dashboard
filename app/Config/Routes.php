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
$routes->get('/dashboard_1', 'Dashboard::index');
$routes->get('/dashboard_2', 'Dashboard::index');
$routes->get('/updates/stream', 'DataManager::stream');
$routes->post('/upload', 'DataManager::process_data');

// Version 1
$routes->get('/summary', 'Summary::index');
$routes->get('/dashboard_v1', 'Dashboard_V1::index');
