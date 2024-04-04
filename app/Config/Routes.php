<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'pages::index');
$routes->get('/posts/create', 'posts::create');
$routes->post('/posts/create', 'posts::create');
$routes->get('/posts', 'posts::post');
