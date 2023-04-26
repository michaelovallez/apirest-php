<?php

use Phroute\Phroute\RouteCollector;
use Firebase\JWT\JWT;
require_once __DIR__ . '/../Controllers/Clientes.php';
require_once __DIR__ . '/../Controllers/Swagger.php';
require_once __DIR__ . '/../Controllers/Authentication.php';
require_once __DIR__ . '/../Config/Middleware.php';

$router = new RouteCollector();

$router->post('apirest-php/authentication', [Authentication::class, 'authenticate']);
$router->filter('middle', function () {
    $middleware = new Middleware();
    $middleware->handle();
    return $middleware->handle();
});
$router->group(['before' => 'middle'], function ($router) {
    $router->post('apirest-php/creacliente', [Clientes::class, 'crearCliente']);
    $router->get('apirest-php/kpideclientes', [Clientes::class, 'kpiClientes']);
    $router->get('apirest-php/listclientes', [Clientes::class, 'listarClientes']);
});


