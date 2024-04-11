<?php

use Config\Services;

$routes = Services::routes();

// Default route
$routes->get('/', 'Pages::index');

// User-related routes
$routes->match(['get', 'post'], '/login', 'UsersController::login');
$routes->match(['get', 'post'], '/register', 'UsersController::register');
$routes->get('/logout', 'UsersController::logout');


//$routes->get('(:num)/edit', 'PostsController::edit/$1');
$routes->get('posts/edit/(:num)', 'PostsController::edit/$1');


// Posts routes
$routes->group('posts', function($routes) {
    $routes->get('', 'PostsController::index');
    $routes->get('create', 'PostsController::create');
    $routes->post('store', 'PostsController::store');
    $routes->get('show/(:num)', 'PostsController::show/$1');
    //$routes->post('(:num)', 'PostsController::update/$1');
    $routes->post('update/(:num)', 'PostsController::update/$1');
    //$routes->get('(:num)/delete', 'PostsController::delete/$1');
    $routes->get('delete/(:num)', 'PostsController::delete/$1');
});

// Dashboard route
$routes->get('posts/dashboard', 'PostsController::dashboard', ['filter' => 'login']);