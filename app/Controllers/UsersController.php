<?php

namespace App\Controllers;

use App\Models\UserModel;

class UsersController extends BaseController
{
    // Method for user login
    public function login()
    {
        $data = [];
        helper(['form']);

        // Check if form is submitted
        if ($this->request->getMethod() === 'post') {
            $rules = [
                'email' => 'required|min_length[6]|max_length[50]|valid_email',
                'password' => 'required|min_length[8]|max_length[255]',
            ];

            // Validate form data
            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
                $model = new UserModel();

                // Attempt to find user by email
                $user = $model->where('email', $this->request->getVar('email'))
                    ->first();

                // If user is found and password is verified, set user session and redirect to posts page
                if ($user && password_verify($this->request->getVar('password'), $user['password'])) {
                    $this->setUserSession($user);
                    return redirect()->to(site_url('posts'));
                } else {
                    // If login fails, display error message and redirect to login page
                    session()->setFlashdata('error', 'Email or Password is incorrect');
                    return redirect()->to('/login');
                }
            }
        }

        return view('pages/login', $data);
    }

    // Method to set user session data
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

    // Method for user registration
    public function register()
    {
        $data = [];
        helper(['form']);

        if ($this->request->is('post'))
        {
            // Validation rules
            $rules = [
                'name' => 'required|min_length[10]|max_length[80]',
                'email' => 'required|min_length[6]|max_length[50]|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]|max_length[255]',
                'password_confirm' => 'matches[password]',
            ];

            // Validate form data
            if (! $this->validate($rules)) {
                $data['validation'] = $this->validator;
            } else {
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
                return redirect()->to('/posts');
            }
        }

        // Load the registration page
        return view('pages/register', $data);
    }

    // Method for user logout
    public function logout()
    {
        session()->destroy(); // Destroys the session and removes session data
        return redirect()->to('/'); // Redirects the user to the landing page
    }
}