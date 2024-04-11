<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user is logged in using session data
        if (! session()->get('isLoggedIn')) {
            // Store the current URL to session for redirecting after login
            session()->set('redirect_url', current_url());

            // Redirect to login page
            return redirect()->to('/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Usually empty, unless you need to perform actions after the controller is executed
    }
}
