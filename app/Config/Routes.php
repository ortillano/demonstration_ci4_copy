<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');
$routes->get('/dashboard', 'Home::index');
$routes->get('/dashboard/create', 'Home::create');
$routes->post('/dashboard/store', 'Home::store');
$routes->get('/dashboard/edit/(:num)', 'Home::edit/$1');
$routes->post('/dashboard/update/(:num)', 'Home::update/$1');
$routes->post('/dashboard/delete/(:num)', 'Home::delete/$1');
$routes->get('/about', 'About::index');
$routes->get('/services', 'Services::index');
$routes->match(['get', 'post'], '/contact', 'Contact::index');
$routes->get('/register', 'Register::index');
$routes->post('/register', 'Register::create');
$routes->get('/account/(:num)', 'Home::viewAccount/$1');
