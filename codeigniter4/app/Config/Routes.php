<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Page d'accueil -> redirige vers login admin
$routes->get('/', function () {
    return redirect()->to('/admin/login');
});

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
});
