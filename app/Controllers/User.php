<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use \Firebase\JWT\JWT;

// headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=utf8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control");

class User extends ResourceController
{
    use ResponseTrait;

    public function createUser()
    {
        $userModel = new UserModel();

        $data = [
            "name" => $this->request->getVar("name"),
            "email" => $this->request->getVar("email"),
            "password" => password_hash($this->request->getVar("password"), PASSWORD_DEFAULT),
        ];

        if ($userModel->insert($data)) {
            $estatus = 200;
            $response = [
                'status' => 200,
                "error" => FALSE,
                'messages' => 'User created',
            ];
        } else {
            $estatus = 500;
            $response = [
                'status' => 500,
                "error" => TRUE,
                'messages' => 'Failed to create',
            ];
        }

        return $this->respondCreated($response);
    }

    private function getKey()
    {
        return "my_application_secret";
    }

    public function validateUser()
    {
        $userModel = new UserModel();

        $userdata = $userModel->where("email", $this->request->getVar("email"))->first();

        if (!empty($userdata)) {

            if (password_verify($this->request->getVar("password"), $userdata['password'])) {

                $key = $this->getKey();

                $iat = time();
                $nbf = $iat + 10;
                $exp = $iat + 3600;

                $payload = array(
                    "iss" => "The_claim",
                    "aud" => "The_Aud",
                    "iat" => $iat,
                    "nbf" => $nbf,
                    "exp" => $exp,
                    "data" => $userdata,
                );

                $token = JWT::encode($payload, $key);

                $estatus = 200;
                $response = [
                    'status' => 200,
                    'error' => FALSE,
                    'messages' => 'User logged In successfully',
                    'token' => $token
                ];
                return $this->respondCreated($estatus);
            } else {

                $estatus = 500;
                $response = [
                    'status' => 500,
                    'error' => TRUE,
                    'messages' => 'Incorrect details'
                ];
                return $this->respondCreated($estatus);
            }
        } else {

            $estatus = 500;
            $response = [
                'status' => 500,
                'error' => TRUE,
                'messages' => 'User not found'
            ];
            return $this->respondCreated($estatus);
        }
    }

    public function userDetails()
    {
        $key = $this->getKey();
        $authHeader = $this->request->getHeader("Authorization");
        $authHeader = $authHeader->getValue();
        $token = $authHeader;

        try {
            $decoded = JWT::decode($token, $key, array("HS256"));

            if ($decoded) {

                $response = [
                    'status' => 200,
                    'error' => FALSE,
                    'messages' => 'User details',
                    'data' => $decoded
                ];
                return $this->respondCreated($response);
            }
        } catch (Exception $ex) {
            $response = [
                'status' => 401,
                'error' => TRUE,
                'messages' => 'Access denied'
            ];
            return $this->respondCreated($response);
        }
    }
}
