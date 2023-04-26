<?php

require_once(__DIR__ . '/../../Controllers/Cliente_controller.php');
require_once __DIR__ . '/../../../Vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();


try {
    $conn = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "CREATE TABLE clientes (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nombre VARCHAR(30) NOT NULL,
        apellido VARCHAR(30) NOT NULL,
        edad INT(3) NOT NULL,
        fecha_nacimiento DATE NOT NULL
    )";

    $conn->exec($sql);
    echo "La tabla clientes ha sido creada exitosamente";
} catch (PDOException $e) {
    echo "Error al crear la tabla clientes: " . $e->getMessage();
}

$conn = null;
