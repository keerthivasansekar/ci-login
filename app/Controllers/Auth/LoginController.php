<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel as Users;
use Firebase\JWT\JWT;

class LoginController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        if ($this->request->is('post')) {
            $userModel = new Users();

            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');

            $user = $userModel->where('user_email', $email)->first();

            if (is_null($user)) {
                return $this->respond([
                    'status' => 'failed',
                    'error' => 'Invalid username or password.'
                ], 200);
            }

            $pwd_verify = password_verify($password, $user['user_password']);

            if (!$pwd_verify) {
                return $this->respond([
                    'status' => 'failed',
                    'error' => 'Invalid username or password.'
                ], 200);
            }

            $key = getenv('JWT_SECRET');
            $iat = time(); // current timestamp value
            $exp = $iat + 3600;

            $payload = array(
                "iss" => base_url(),
                "aud" => "Web App",
                "sub" => "Auth Tokens",
                "iat" => $iat, //Time the JWT issued at
                "exp" => $exp, // Expiration time of token
                "email" => $user['user_email'],
            );

            $token = JWT::encode($payload, $key, 'HS256');

            $data = [
                'user_name' => $user['user_name'],
                'user_email' => $user['user_email'],
                'auth_token' => $token,
                'is_loggedin' => true
            ];

            $session = session();
            $session->set($data);

            $response = [
                'status' => "200",
                'message' => 'Login Succesful',
            ];

            return $this->respond($response, 200);
        } else {
            $data['_viewfile'] = 'auth/login';
            return view('layouts/auth', $data);
        }
    }
}
