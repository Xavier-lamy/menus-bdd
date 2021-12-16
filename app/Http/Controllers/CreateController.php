<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use App\Rules\CommandIdValided;
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
        $request->validate([
            'quantity' => ['required', 'min:0', 'integer'],
            'useby_date' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'command_id' => [new CommandIdValided],
        ]);

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
        $request->validate([
            'ingredient' => ['required', 'min:1', 'max:60', 'string'],
            'quantity_name' => ['required', 'min:1', 'max:40', 'string'],
            'alert_stock' => ['required', 'min:0', 'integer'],
        ]);

        $ingredient = strtolower($request->ingredient);
        $quantity_name = strtolower($request->quantity_name);
        $alert_stock = $request->alert_stock;
        $product_exist = Command::where('ingredient', $ingredient)->where('quantity_name', $quantity_name)->first();

        if(!empty($product_exist)){
            return redirect('total-stocks')->with('message', "Product: {$ingredient} ({$quantity_name}),already exists !");
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
