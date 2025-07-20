<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/manage', 'Home::managekonser');
$routes->post('/manage', 'Home::saveConcert');

$routes->get('/admin-ticket', 'Home::adminTicket');
$routes->get('/ticket/index/(:num)', 'Ticket::index/$1');
$routes->get('/ticket/create/(:num)', 'Ticket::create/$1');
$routes->post('/ticket/store/(:num)', 'Ticket::store/$1');
$routes->post('/ticket/delete/(:num)', 'Ticket::delete/$1');

$routes->resource('concert');
$routes->get('ticket/concert/(:num)', 'Ticket::byConcert/$1');
$routes->resource('ticket');
$routes->resource('order');
