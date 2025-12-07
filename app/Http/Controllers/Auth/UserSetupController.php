<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserSetupController extends Controller
{
    /**
     * Show the setup / verification required page.
     */
    public function index()
    {
        return view('user.setup');
    }
}
