<?php
require_once(__DIR__ . '/../Models/Cliente_model.php');
require_once(__DIR__ . '/Controller.php');
require_once(__DIR__ . '/../Utils/jwt.php');

class Authentication extends Controller
{

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        header('Content-Type: application/json');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

    }
    public function authenticate()
    {
        $data = [
            'username'=> $_POST['username'],
            'password'=> $_POST['password']
        ];
        $username = $_ENV['AUTH_USERNAME'];
        $password = $_ENV['AUTH_PASSWORD'];
        if ($data['username'] == $username && $data['password'] == $password) {
            $jwt = new JWTAuth($_ENV['JWT_SECRET_KEY']);
            $token = $jwt->generateToken(); // El identificador del usuario autenticado.
            
            return json_encode(['token' => $token]);
        } else {
            http_response_code(403);
            return json_encode(['error' => 'Usuario o contraseña incorrectos',]);
        }
    }
}
