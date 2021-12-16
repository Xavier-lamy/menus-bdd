<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    //Stocks
    public function create_stock_product() {
        $is_creating = true;
        $products = Stock::all();
        $commands_products = Command::orderBy('ingredient')->get();

        return view('stocks', [
            'products' => $products,
            'commands_products' => $commands_products,
            'is_creating' => $is_creating,
        ]);
    }

    public function add_stock_product(Request $request) {
        $id = $request->command_id;
        $commands_product = Command::find($id);

        Stock::create([
            'ingredient' => $commands_product->ingredient,
            'quantity' => $request->quantity,
            'quantity_name' => $commands_product->quantity_name,
            'useby_date' => $request->useby_date,
            'command_id' => $id,
        ]);

        $alert_stock = $commands_product->alert_stock;
        $command_quantity = $commands_product->quantity;
        $stock_quantity = $request->quantity;
        $newquantity = $command_quantity + $stock_quantity;
        if($newquantity <= $alert_stock){
            $must_buy = 1;
        }
        else {
            $must_buy = 0;
        }

        $commands_product->update([
            'quantity' => $newquantity,
            'must_buy' => $must_buy,
        ]);

        return redirect('stocks')->with('success', 'New product added to stocks');
    }

    //Commands
    public function create_command_product() {
        $is_creating = true;
        $products = Command::all();

        return view('total-stocks', [
            'products' => $products,
            'is_creating' => $is_creating,
        ]);
    }

    public function add_command_product(Request $request) {
        $ingredient = $request->ingredient;
        $quantity_name = $request->quantity_name;
        $alert_stock = $request->alert_stock;
        $product_exist = Command::where('ingredient', $ingredient)->where('quantity_name', $quantity_name)->first();

        if(!empty($product_exist)){
            return redirect('total-stocks')->with('message', 'Product already exists !');
        }
        else {
            Command::create([
                'ingredient' => $ingredient,
                'quantity' => 0,
                'quantity_name' => $quantity_name,
                'alert_stock' => $alert_stock,
                'must_buy' => 1,
            ]);

            return redirect('total-stocks')->with('success', 'Product successfully added !');            
        }
    }
}