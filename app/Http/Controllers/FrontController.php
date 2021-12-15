<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //Define returning views functions
    public function index() {
        return view('front');
    }

    public function stocks() {
        return view('stocks');
    }

    public function show_safety_stocks() {
   /*      $products = Command::all */
        return view('safety-stocks');
    }
}
