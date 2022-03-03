<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    /**
     * Define middlewares in class construct
     */
    public function __construct() {
        //Force use of authentication
        $this->middleware('auth');
    }

    /**
     *  Display the shopping list
     */ 
    public function index() {
        $user_id = Auth::user()->id;

        $products = Command::where([
            'must_buy' => 1,
            'user_id' => $user_id,
        ])->get();

        return view('front', [
            'products' => $products,
        ]);
    }
}
