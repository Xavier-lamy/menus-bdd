<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //Shopping list
    public function index() {
        $products = Command::where('must_buy', 1)->get();
        return view('front', [
            'products' => $products,
        ]);
    }
}
