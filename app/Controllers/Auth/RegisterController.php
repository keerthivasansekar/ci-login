<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class RegisterController extends BaseController
{
    public function index()
    {
        $data['_viewfile'] = 'auth/register';
        return view('layouts/auth', $data);
    }

    public function forgot_password(){
        $data['_viewfile'] = 'auth/forgot_password';
        return view('layouts/auth', $data);
    }

    public function verify_otp(){
        $data['_viewfile'] = 'auth/verify_otp';
        return view('layouts/auth', $data);
    }

    public function reset_password(){
        $data['_viewfile'] = 'auth/reset_password';
        return view('layouts/auth', $data);
    }
}
