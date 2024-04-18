<?php

namespace App\Controllers;

// Handles the pages
class Pages extends BaseController
{
    // Method for handling the index page
    public function index()
    {
        // Load a view for the landing page
        return view('pages/landing');
    }
}

