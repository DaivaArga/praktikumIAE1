<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// app/Config/Routes.php
$routes->get('/', 'Home::index');
$routes->get('books', 'BookController::index');
$routes->get('books/(:num)', 'BookController::detail/$1');
$routes->put('books/(:num)', 'BookController::update/$1');
$routes->delete('books/(:num)', 'BookController::delete/$1');
$routes->get('members', 'MemberController::index');
$routes->get('members/(:num)', 'MemberController::detail/$1');
$routes->put('members/(:num)', 'MemberController::update/$1');
$routes->delete('members/(:num)', 'MemberController::delete/$1');