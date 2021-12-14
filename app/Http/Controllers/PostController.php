<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        return view('front');
    }

    public function show_stocks() {
        return view('stocks');
    }

    public function show_safety_stocks() {
        return view('safety-stocks');
    }
}
