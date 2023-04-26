<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class JWTAuth {

    private $secretKey;
    private $issuedAt;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
        $this->issuedAt = time();
    }

    public function generateToken() {
        $payload = [
            'iat' => $this->issuedAt, // Tiempo de creación del token.
            'iss' => $_SERVER['SERVER_NAME'], // Emisor del token.
            'exp' => $this->issuedAt + (60 * 60 * 24), // Tiempo de expiración del token (24 horas).
        ];
        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        return $jwt;
    }

    public function validateToken($token) {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, 'HS256'));
           // var_dump($decoded);
            return $decoded;
        } catch (\Exception $e) {
            return false;
        }
    }

}
