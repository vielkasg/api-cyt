<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('v1',  function () use ($routes) {
    $routes->options('v1', static function () {});
    $routes->group('auth', function () use ($routes) {
        $routes->post('login', 'Auth::login');
    });

    $routes->group('franjas', ['filter' => 'auth'], function () use ($routes) {
        $routes->get('lista/(:num)/(:num)', 'Franjas::listaFranjas/$1/$2');
        $routes->get('rutas', 'Franjas::getCatalogoRutas');
    });
});
