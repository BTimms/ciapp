<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use Myth\Auth\Config\Auth as AuthConfig;
use Myth\Auth\Authentication\LocalAuthenticator;

class LoginController extends BaseController
{
    /**
     * @var AuthConfig
     */
    protected $config;

    /**
     * @var LocalAuthenticator
     */
    protected $auth;

    public function __construct()
    {
        $this->config = config('Auth');
        $this->auth = service('authentication');
    }

    // Method for displaying the login form
    public function index()
    {
        // Check if the user is already logged in
        if ($this->auth->check()) {
            return redirect()->to(base_url($this->config->landingRoute));
        }

        // Pass the config to the view
        return view('Auth/login', [
            'config' => $this->config
        ]);
    }

    // Method for attempting user login
    public function attemptLogin()
    {
        // Validation rules for email and password
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        // Validate input data
        if (!$this->validate($rules)) {
            return redirect()->to('login')->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get email, password, and remember me status from request
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $remember = $this->request->getVar('remember') === 'on';

        // Attempt user login
        if (!$this->auth->attempt(['email' => $email, 'password' => $password], $remember)) {
            // If login fails, set flash message and redirect back to login page with input data
            session()->setFlashdata('error', lang('Auth.badAttempt'));
            return redirect()->back()->withInput();
        }

        // Get redirect URL from session or use landing route from config
        $redirectURL = session('redirect_url') ?? base_url($this->config->landingRoute);
        unset($_SESSION['redirect_url']);

        // Redirect user to the appropriate page after successful login
        return redirect()->to($redirectURL);
    }

    // Method for user logout
    public function logout()
    {
        // Logout the user
        $this->auth->logout();

        // Redirect user to the home page with a success message
        return redirect()->to(base_url('/'))->with('success', 'Logout successful');
    }
}
