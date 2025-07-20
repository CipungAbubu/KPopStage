<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
 $routes->get('/', 'Home::index');
 $routes->get('/manage', 'Home::managekonser');
 $routes->post('/manage', 'Home::saveConcert');
$routes->get('/manage-tickets', 'Home::manageTickets');
$routes->get('/manage-artists', 'Home::manageArtists');
$routes->get('/manage-venues', 'Home::manageVenues');
$routes->get('/manage-orders', 'Home::manageOrders');
 
 $routes->resource('concert');
 $routes->get('ticket/concert/(:num)', 'Ticket::byConcert/$1');
 $routes->resource('ticket');
$routes->resource('artist');
$routes->resource('venue');
 $routes->resource('order');
