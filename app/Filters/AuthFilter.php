<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthFilter implements FilterInterface
{
    
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $key = getenv('JWT_SECRET');
        $token = $session->get('auth_token');
    
        // check if token is null or empty
        if(is_null($token) || empty($token)) {
            return redirect()->to('auth/login');
        }
  
        try {
            // $decoded = JWT::encode($token, $key, array("HS256"));
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Throwable $ex) {
            return redirect()->to('auth/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
