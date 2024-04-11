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

    public function index()
    {
        return view('Auth/register', [
            'config' => config('Auth')
        ]);
    }

    public function attemptRegister()
    {
        $rules = [
            'name'     => 'required|string|max_length[255]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new UserModel();

        $userData = [
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // No need to hash here, Myth\Auth will handle it
        ];

        if ($userModel->insert($userData)) {
            // Automatically log in the user after registration
            $user = $userModel->where('email', $userData['email'])->first();
            $this->auth->login($user);

            return redirect()->to(base_url($this->config->landingRoute));
        } else {
            return redirect()->back()->withInput()->with('errors', $userModel->errors());
        }
    }
}
