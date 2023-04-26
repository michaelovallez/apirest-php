<?php
require_once __DIR__ . '/../../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

class Controller
{

    private $conn;

    private $cliente_model;
    public function __construct()
    {
        
    }
}