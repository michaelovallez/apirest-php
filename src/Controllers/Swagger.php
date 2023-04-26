<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once(__DIR__ . '/Controller.php');

class Swagger extends Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/x-yaml');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    }
    // Endpoint de Entrada POST /creacliente
    public function swagger()
    {

        $openapi = \OpenApi\Generator::scan(['./Clientes.php']);
        echo $openapi->toYaml();
    }
}
