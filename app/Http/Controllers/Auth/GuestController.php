<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Define app behavior when user is not logged
     */
    public function notLoggedIn()
    {
        return view('auth.guest');
    }
}
