<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    //Stocks
    public function show_stocks() {
        $products = Stock::all();
        return view('stocks', [
            'products' => $products,
        ]);
    }

    //Commands
    public function show_total_stocks() {
        $products = Command::all();

        return view('total-stocks', [
            'products' => $products,
        ]);
    }
}
