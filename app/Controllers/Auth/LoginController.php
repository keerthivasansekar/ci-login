<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        $data['_viewfile'] = 'auth/login';
        return view('layouts/auth', $data);
    }
}
