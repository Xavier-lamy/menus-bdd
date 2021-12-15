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
        $products = Command::all();

        return view('safety-stocks', [
            'products' => $products,
        ]);
    }

    public function create_command_product() {
        $is_creating = true;
        $products = Command::all();

        return view('safety-stocks', [
            'products' => $products,
            'is_creating' => $is_creating,
        ]);
    }

    public function add_command_product(Request $request) {

        Command::create([
            'ingredient' => $request->ingredient,
            'quantity' => 0,
            'quantity_name' => $request->quantity_name,
            'alert_stock' => $request->alert_stock,
            'must_buy' => 1,
        ]);

        return redirect('safety-stocks')->with('success', 'Product successfully added !');
    }
}
