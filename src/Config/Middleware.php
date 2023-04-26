<?php
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();
require_once(__DIR__ . '/../Utils/jwt.php');

class Middleware
{
    public function __construct()
    {
    }
    public function handle()
    {
        //var_dump('Middleware executed.');
        $headers = apache_request_headers();
        $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
        $token = str_replace('Bearer ', '', $authorizationHeader);

        if (!$token) {
            http_response_code(401);
            return json_encode(['message' => 'Token not provided.']);
        }

        try {
            $jwt = new JWTAuth($_ENV['JWT_SECRET_KEY']);
            $decodedToken = $jwt->validateToken($token);
            if (!$decodedToken) {
                http_response_code(401);
                return json_encode(['message' => 'este Invalid token.']);
            }
        } catch (Exception $e) {
            http_response_code(401);
            return json_encode(['message' => 'Invalid token.']);
        }
    }
}
