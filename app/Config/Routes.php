<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Public Pages (viewable by anyone)
$routes->get('/', 'Welcome::index');
$routes->get('about', 'About::index');
$routes->get('profile', 'Profile::index');
$routes->get('tasks', 'Tasks::index');

// Authentication Routes
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::attempt');
$routes->post('logout', 'Auth::logout');

// Protected Task Management Routes (restricted by AuthFilter)
$routes->group('tasks', ['filter' => 'auth'], static function ($routes) {
    $routes->get('new', 'Tasks::new');
    $routes->post('', 'Tasks::create');
    $routes->get('(:num)/edit', 'Tasks::edit/$1');
    $routes->post('(:num)', 'Tasks::update/$1');
    $routes->post('(:num)/delete', 'Tasks::delete/$1');
});
