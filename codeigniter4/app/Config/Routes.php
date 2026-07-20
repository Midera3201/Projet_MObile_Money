<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ClientController::login');
$routes->get('/login', 'ClientController::login');
$routes->post('/login', 'ClientController::login');
$routes->get('/logout', 'ClientController::logout');
$routes->get('/client/dashboard', 'ClientController::dashboard');
$routes->get('/client/depot', 'ClientController::depot');
$routes->post('/client/depot', 'ClientController::storeDepot');
$routes->get('/client/retrait', 'ClientController::retrait');
$routes->post('/client/retrait', 'ClientController::storeRetrait');
$routes->get('/client/transfert', 'ClientController::transfert');
$routes->post('/client/transfert', 'ClientController::storeTransfert');
$routes->get('/client/historique', 'ClientController::historique');

$routes->get('/hello', 'Home::index');
$routes->get('/produits', 'Produits::index');
$routes->get('/produits/(:num)', 'Produits::show/$1');
