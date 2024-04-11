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

    public function attemptLogin()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('login')->withInput()->with('errors', $this->validator->getErrors());
        }

        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $remember = $this->request->getVar('remember') === 'on';

        if (!$this->auth->attempt(['email' => $email, 'password' => $password], $remember)) {
            session()->setFlashdata('error', lang('Auth.badAttempt'));
            return redirect()->back()->withInput();
        }

        $redirectURL = session('redirect_url') ?? base_url($this->config->landingRoute);
        unset($_SESSION['redirect_url']);

        return redirect()->to($redirectURL);
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect()->to(base_url('/'))->with('success', 'Logout successful');
    }
}
