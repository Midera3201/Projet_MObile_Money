<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Page d'accueil
$routes->get('/', 'HomeController::index');

// Login / Logout Admin
$routes->get('/admin/login', 'Admin\AuthController::showLogin');
$routes->post('/admin/login', 'Admin\AuthController::login');
$routes->get('/admin/logout', 'Admin\AuthController::logout');

// Espace Admin (protege par le filtre adminAuth)
$routes->group('admin', ['filter' => 'adminAuth'], function ($routes) {

    // Dashboard
    $routes->get('/', 'Admin\DashboardController::index');

    // Prefixes
    $routes->get('prefixes', 'Admin\PrefixController::index');
    $routes->post('prefixes/create', 'Admin\PrefixController::create');
    $routes->get('prefixes/delete/(:num)', 'Admin\PrefixController::delete/$1');
    $routes->get('prefixes/toggle/(:num)', 'Admin\PrefixController::toggle/$1');

    // Types d'operations
    $routes->get('types', 'Admin\TypeOperationController::index');
    $routes->post('types/create', 'Admin\TypeOperationController::create');
    $routes->get('types/delete/(:num)', 'Admin\TypeOperationController::delete/$1');

    // Baremes de frais
    $routes->get('baremes', 'Admin\BaremeController::index');
    $routes->post('baremes/create', 'Admin\BaremeController::create');
    $routes->get('baremes/delete/(:num)', 'Admin\BaremeController::delete/$1');

    // Operateurs externes
    $routes->get('operateurs', 'Admin\OperateurExterneController::index');
    $routes->post('operateurs/create', 'Admin\OperateurExterneController::create');
    $routes->get('operateurs/toggle/(:num)', 'Admin\OperateurExterneController::toggle/$1');
    $routes->get('operateurs/delete/(:num)', 'Admin\OperateurExterneController::delete/$1');

    // Commissions
    $routes->get('commissions', 'Admin\CommissionController::index');
    $routes->post('commissions/update/(:num)', 'Admin\CommissionController::update/$1');

    // Simulateur de transfert
    $routes->get('simulateur', 'Admin\TransferController::simulateur');
    $routes->post('simulateur', 'Admin\TransferController::simulateur');

    // Reporting
    $routes->get('reporting/gains', 'Admin\ReportingController::gains');
    $routes->get('reporting/montants', 'Admin\ReportingController::montantsAEnvoyer');
});

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
