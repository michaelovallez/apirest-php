<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once(__DIR__ . '/../Models/Cliente_model.php');
require_once(__DIR__ . '/Controller.php');

class Clientes extends Controller
{


    private $cliente_model;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        $this->cliente_model = new Cliente();


    }
    /**
     * @OA\Post(
     *     path="/apirest-php/creacliente",
     *     tags={"clientes"},
     *     summary="Crear un nuevo cliente",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="nombre", type="string"),
     *             @OA\Property(property="apellido", type="string"),
     *             @OA\Property(property="edad", type="integer"),
     *             @OA\Property(property="fecha_nacimiento", type="string", format="date")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Cliente creado con éxito", @OA\JsonContent(ref="#/components/schemas/Cliente")),
     *     @OA\Response(response="400", description="Error en la solicitud", @OA\JsonContent(example={"error": "Todos los campos son obligatorios"}))
     * )
     */
    // Endpoint de Entrada POST /creacliente
    public function crearCliente()
    {
        // Leer los datos enviados en la solicitud POST
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $edad = $_POST['edad'];
        $fecha_nacimiento = $_POST['fecha_nacimiento'];

        // Validar los datos recibidos
        if (empty($nombre) || empty($apellido) || empty($edad) || empty($fecha_nacimiento)) {
            return json_encode(array('error' => 'Todos los campos son obligatorios'));
        }
        if (!is_numeric($edad) || $edad <= 0) {
            return json_encode(array('error' => 'La edad debe ser un número positivo'));
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento)) {
            return json_encode(array('error' => 'La fecha de nacimiento debe tener el formato YYYY-MM-DD'));
        }

        // Crear un nuevo objeto Cliente con los datos validados
        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->edad = $edad;
        $cliente->fecha_nacimiento = $fecha_nacimiento;

        // Guardar el cliente en la base de datos
        $cliente->save_cliente();

        // Retornar una respuesta con el nuevo cliente creado
        return json_encode(array('mensaje' => 'Cliente creado con éxito', 'cliente' => $cliente));
    }
    public function kpiClientes()
    {
        // Obtener el promedio de edad y la desviación estándar de la edad de los clientes a través del modelo
        $promedio = $this->cliente_model->calcularPromedioEdad();
        $desviacion_estandar = $this->cliente_model->calcularDesviacionEstandarEdad();

        // Retornar una respuesta con los datos obtenidos
        return json_encode(array('promedio_edad' => $promedio, 'desviacion_estandar_edad' => $desviacion_estandar));
    }
    // Endpoint de salida GET /listclientes
    public function listarClientes()
    {
        $clientes = $this->cliente_model->listar();

        foreach ($clientes as &$cliente) {
            $cliente['fecha_probable_muerte'] = $this->cliente_model->calcularFechaProbableMuerte($cliente['edad'], $cliente['fecha_nacimiento']);
        }

        return json_encode($clientes);
    }
}
