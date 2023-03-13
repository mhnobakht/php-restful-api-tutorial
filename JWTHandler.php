<?php

require_once 'vendor/autoload.php';

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTHandler {

    private $key = "31eba0d418082274bda56147df961e4871d7f29120d29859a09f433b17de49c71c";

    public function createToken($user) {

        $payload = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'exp' => time() + (60 * 60)
        ];

        $jwt = JWT::encode($payload, $this->key, 'HS256');

        return $jwt;
    }

    public function validateToken($jwt) {

        try {
            $decode = JWT::decode($jwt, new Key($this->key, 'HS256'));

            if($decode->exp < time()) {
                return false;
            }

            return true;
        }catch (Exception $e) {
            return false;
        }
        
    }

}


//==================================
// $jwt = new JWTHandler();
// $user = [
//     'id' => 1,
//     'name' => 'majid',
//     'email' => 'majid@gmail.com'
// ];
// echo $jwt->createToken($user);
// $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MSwibmFtZSI6Im1hamlkIiwiZW1haWwiOiJtYWppZEBnbWFpbC5jb20iLCJleHAiOjE2Nzg3MjY3MjF9.6Yh748Dijpv5h5koc0IDTAF0T7HiqIYuVcTZsB4EBJ8';

// var_dump($jwt->validateToken($token));