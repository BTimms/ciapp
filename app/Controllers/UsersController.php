<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    public function login()
    {
        $data = [];
        helper(['form']);

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new UserModel();

                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();

                if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                    $this->setUserSession($user);
                    return redirect()->to(site_url('posts'));
                } else {
                    session()->setFlashdata('error', 'Email or Password is incorrect');
                    return redirect()->to('/login');
                }
            }
        }

        return view('pages/login', $data);
    }

    private function setUserSession($user) {
        $data = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'isLoggedIn' => true,
        ];

        session()->set($data);
        return true;

    }


    public function register()
    {
        $data = [];
        helper(['form']);

        if ($this->request->is('post'))
        {
            // Validations
            $rules = [
                'name' => 'required|min_length[10]|max_length[80]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            }else{
                // Store the user in the database
                $model = new UserModel();

                $newData = [
                    'name' => $this->request->getVar('name'),
                    'email' => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'),
                ];
                $model->save($newData);
                $session = session();
                $session->setFlashdata('success', 'Successful Registration');
                return redirect()->to('/login');

            }
        }

        // Load a register page
        return view('pages/register', $data);
    }

    public function logout()
    {
        session()->destroy(); // Destroys the session and removes session data
        return redirect()->to('/'); // Redirects the user to the landing page
    }



}
