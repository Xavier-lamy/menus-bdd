<?php

namespace App\Http\Controllers;

use App\Models\Command;
use Carbon\Carbon;

class FrontController extends Controller
{
    //Shopping list
    public function index() {
        $products = Command::where('must_buy', 1)->get();
        return view('front', [
            'products' => $products,
        ]);
    }

    public static function checkProductExpire($date){
        $current = Carbon::now()->format('Y-m-d');
        //Force correct format for returned date:
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $diffInDays = $date->diffInDays($current);

        if($date->lt($current)){
            return $class_sufix='-warning';
        }
        elseif($diffInDays <= 10 && $diffInDays >= 1) {
            return $class_sufix='-message';
        }
        else {
            return $class_sufix='-success';
        }  
    }
}
