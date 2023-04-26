<?php
require_once './vendor/autoload.php';
require_once './src/Routes/Api.php';

use Phroute\Phroute\Dispatcher;

$dispatcher = new Dispatcher($router->getData());

try {
    //var_dump(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $response = $dispatcher->dispatch($_SERVER['REQUEST_METHOD'], parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    echo $response;
} catch (\Phroute\Phroute\Exception\HttpRouteNotFoundException $e) {
    http_response_code(404);
    echo json_encode(array('mensaje' => 'No se encontró la ruta especificada','estatus'=>404));
} catch (\Exception $e) {
    http_response_code(500);
    echo json_encode(array('mensaje' => 'Ocurrió un error interno en el servidor'));
}

