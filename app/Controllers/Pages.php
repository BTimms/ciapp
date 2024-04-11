<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        // Load a view for the landing page
        return view('pages/landing');
    }
}

