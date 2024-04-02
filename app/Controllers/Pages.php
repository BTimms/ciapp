<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Pages extends Controller
{
    public function index()
    {
        // Load a view for the landing page
        echo view('pages/index');
    }

    // Additional methods for other pages can be added here
}
