<?php
require_once(__DIR__ . '/Model.php');
class Cliente extends Model{
  public $id;
  public $nombre;
  public $apellido;
  public $edad;
  public $fecha_nacimiento;

  public function save_cliente() {
    $query = 'INSERT INTO clientes (nombre, apellido, edad, fecha_nacimiento) VALUES (?, ?, ?, ?)';
    $params = array($this->nombre, $this->apellido, $this->edad, $this->fecha_nacimiento);
    $this->executeQuery($query, $params);
    $this->id = $this->conn->lastInsertId();
  }
  public function listar()
  {
    $query = 'SELECT * FROM clientes';
    $stmt = $this->executeQuery($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function calcularPromedioEdad()
  {
    $query = 'SELECT AVG(edad) as promedio_edad FROM clientes';
    $stmt = $this->executeQuery($query);
    return $stmt->fetch(PDO::FETCH_ASSOC)['promedio_edad'];
  }

  public function calcularDesviacionEstandarEdad()
  {
    $query = 'SELECT STDDEV(edad) as desviacion_estandar_edad FROM clientes';
    $stmt = $this->executeQuery($query);
    return $stmt->fetch(PDO::FETCH_ASSOC)['desviacion_estandar_edad'];
  }

  public function calcularFechaProbableMuerte()
  {
    $hoy = new DateTime();
    $edad = $this->edad;
    $fecha_nacimiento = new DateTime($this->fecha_nacimiento);
    $fecha_nacimiento->modify('+1 year');
    $probable_muerte = $fecha_nacimiento->add(new DateInterval('P' . (100 - $edad) . 'Y'));
    return $probable_muerte->format('Y-m-d');
  }
  public function obtenerListaClientes()
  {
    $stmt = $this->conn->prepare('SELECT * FROM clientes');
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Calcular la fecha probable de muerte de cada cliente
    foreach ($clientes as &$cliente) {
      $fechaNacimiento = new DateTime($cliente['fecha_nacimiento']);
      $edad = $fechaNacimiento->diff(new DateTime('now'))->y;
      $esperanzaVida = 75; // Valor promedio, se puede obtener de otra fuente
      $fechaMuerte = $fechaNacimiento->add(new DateInterval('P' . ($esperanzaVida - $edad) . 'Y'));
      $cliente['fecha_muerte'] = $fechaMuerte->format('Y-m-d');
    }

    return $clientes;
  }
}





