<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use Myth\Auth\Authentication\LocalAuthenticator;
use Myth\Auth\Models\UserModel;
use Myth\Auth\Entities\User;
use CodeIgniter\HTTP\RedirectResponse;

class RegisterController extends BaseController
{
    protected $auth;

    public function __construct()
    {
        $this->auth = service('authentication');
        $this->config = config('Auth');

    }

    // Method for displaying the registration form
    public function index()
    {
        return view('Auth/register', [
            'config' => config('Auth')
        ]);
    }

    // Method for attempting user registration
    public function attemptRegister()
    {
        // Validation rules for registration form fields
        $rules = [
            'name'     => 'required|string|max_length[255]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        // Validate input data
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        // Prepare user data for insertion into the database
        $userData = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // No need to hash here, Myth\Auth will handle it
        ];

        // Attempt to insert the user into the database
        if ($userModel->insert($userData)) {
            // Automatically log in the user after registration
            $user = $userModel->where('email', $userData['email'])->first();
            $this->auth->login($user);

            // Redirect user to the landing page after successful registration
            return redirect()->to(base_url($this->config->landingRoute));
        } else {
            // If registration fails, redirect back to the registration page with input data and errors
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }
}
