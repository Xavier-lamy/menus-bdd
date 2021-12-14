<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    //Define returning views functions
    public function index() {
        return view('front');
    }

    public function stocks() {
        return view('stocks');
    }

    public function safety_stocks() {
        return view('safety-stocks');
    }
}
