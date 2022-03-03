<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Illuminate\Support\Facades\Auth;

class FrontController extends Controller
{
    //Shopping list
    public function index() {
        if (Auth::check()){
            $user_id = Auth::user()->id;

            $products = Command::where([
                'must_buy' => 1,
                'user_id' => $user_id,
            ])->get();

            return view('front', [
                'products' => $products,
            ]);
        }
        abort(404);
    }
}
