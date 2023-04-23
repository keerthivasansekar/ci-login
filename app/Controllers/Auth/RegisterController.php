<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\UsersModel as Users;

class RegisterController extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        if ($this->request->is('post')) {
            $rules = [
                'name' => ['rules' => 'required|min_length[4]|max_length[255]'],
                'email' => ['rules' => 'required|min_length[4]|max_length[255]|valid_email|is_unique[users.user_email]'],
                'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
                'confirmpass'  => ['label' => 'confirm password', 'rules' => 'required|matches[password]'],
                'terms' => ['rules' => 'required']
            ];

            if ($this->validate($rules)) {
                $model = new Users();
                $data = [
                    'user_name'     => $this->request->getVar('name'),
                    'user_email'    => $this->request->getVar('email'),
                    'user_password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
                    'user_deleted'  => 0
                ];
                $model->save($data);

                return $this->respond([
                    'status' => 'success',
                    'message' => 'Registered Successfully'
                ], 200);
            } else {
                return $this->respond([
                    'status' => 'failed',
                    'messages' => [
                        "errName" => $this->validator->getError('name'),
                        "errEmail" => $this->validator->getError('email'),
                        "errPassword" => $this->validator->getError('password'),
                        "errConfirmPass" => $this->validator->getError('confirmpass'),
                        "errTerms" => $this->validator->getError('terms'),
                    ],
                ], 200);
            }
        } else {
            $data['_viewfile'] = 'auth/register';
            return view('layouts/auth', $data);
        }
    }

    public function forgot_password()
    {
        if ($this->request->is('post')) {
            $userModel = new Users();

            $email = $this->request->getVar('email');
            $user = $userModel->where('user_email', $email)->first();

            if (is_null($user)) {
                $response = [
                    'status' => 'failed',
                    'error' => 'Invalid or No registered email'
                ];
                return $this->respond($response, 200);
            }

            $otp = rand(100000, 999999);
            $forgot_password_token = sha1($otp);

            $userModel->set('user_fp_token', $forgot_password_token);
            $userModel->where('user_id', $user['user_id']);
            $userModel->update();

            $this->otp_email($user['user_email'], $otp);

            $session = session();
            $session->set(['reset_email' => $user['user_email']]);

            $response = [
                'status' => 'success',
                'message' => "Password reset otp sent to Email"
            ];

            return $this->respond($response, 200);
        } else {
            $data['_viewfile'] = 'auth/forgot_password';
            return view('layouts/auth', $data);
        }
    }

    public function verify_otp(){
        if ($this->request->is('post')) {
            $session = session();
            $email = $session->get('reset_email');
            $otp = $this->request->getVar('otp');

            $userModel = new Users();
            $user = $userModel->where('user_email', $email)->first();

            if (is_null($user)) {
                $response = [
                    'status' => "failed",
                    'error' => "Something went wrong please try again",
                ];
                return $this->respond($response, 200);
            }

            if (sha1($otp) === $user['user_fp_token']) {
                $response = [
                    'status' => "success",
                    'message' => "OTP verified successfully",
                    
                ];
                $session->set(['auth_token' => $user['user_fp_token']]);
                return $this->respond($response, 200);
            } else {
                $response = [
                    'status' => "failed",
                    'error' => "OTP verification failed",
                ];
                return $this->respond($response, 200);
            }
        } else {
            $data['_viewfile'] = 'auth/verify_otp';
            return view('layouts/auth', $data);
        }
    }

    public function reset_password()
    {
        if ($this->request->is('post')) {
            $rules = [
                'password' => ['rules' => 'required|min_length[8]|max_length[255]'],
                'confirmpass'  => [ 'label' => 'confirm password', 'rules' => 'required|matches[password]']
            ];
    
            if ($this->validate($rules)) {
                $userModel = new Users();
                $session = session();
                $authtoken = $session->get('auth_token');
                $hashed_password = password_hash($this->request->getVar('password'), PASSWORD_DEFAULT);
                $user = $userModel->where('user_fp_token', $authtoken)->first();
                if (!is_null($user)) {
                    $data = [
                        'user_fp_token' => null,
                        'user_password' => $hashed_password
                    ];
    
                    $userModel->set($data);
                    $userModel->where('user_id', $user['user_id']);
                    $userModel->update();
                    $response = [
                        'status' => "success",
                        'message' => "Password reset successfully",
                    ];
                    return $this->respond($response, 200);
                } else {
                    $response = [
                        'status' => "failed",
                        'error' => "Something went wrong please try again",
                    ];
                    return $this->respond($response, 200);
                }
                
            } else {
                $response = [
                    'status' => "200",
                    'errors' => [
                        "errPassword" => $this->validator->getError('password'),
                        "errConfirmPassword" => $this->validator->getError('confirm_password'),
                    ],
                ];
                return $this->respond($response, 200);
            }
        } else {
            $data['_viewfile'] = 'auth/reset_password';
            return view('layouts/auth', $data);
        }

    }

    private function otp_email($toEmail, $otp){
        $email = \Config\Services::email();

        $email->setFrom('test@angular-crud.loc', 'Angular Crud');
        $email->setTo($toEmail);

        $email->setSubject('Email OTP to reset password');
        $message = "Your OTP to reset password is: " . $otp;
        $email->setMessage($message);

        try {
            $email->send();
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
