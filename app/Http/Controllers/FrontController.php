<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    //Define returning views functions
    public function index() {
        $products = Command::where('must_buy', 1)->get();
        return view('front', [
            'products' => $products,
        ]);
    }

    /**Stocks */
    public function show_stocks() {
        $products = Stock::all();
        return view('stocks', [
            'products' => $products,
        ]);
    }

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

    public function modify_stock_product($id) {
        $products = Stock::all();

        return view('stocks', [
            'products' => $products,
            'modifying_product_id' => $id,
        ]);
    }

    public function apply_stock_product_modifications(Request $request) {
        //Fetch data from request
        $stock_id = $request->id;
        $command_id = $request->command_id;
        $stock_quantity = $request->quantity;
        $useby_date = $request->useby_date;
        
        //Fetch ancient value for stock quantity
        $stocks_product = Stock::find($stock_id);
        $old_stock_quantity = $stocks_product->quantity;

        //update product in stocks
        $stocks_product->update([
            'quantity' => $stock_quantity,
            'useby_date' => $useby_date,
        ]);

        //update product in commands
        $commands_product = Command::find($command_id);

        $alert_stock = $commands_product->alert_stock;
        $command_quantity = $commands_product->quantity;
        $newquantity = ($command_quantity - $old_stock_quantity) + $stock_quantity;
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

        return redirect('stocks')->with('success', 'Product modified !');
    }

    public function delete_stock_products_confirmation(Request $request){
        $delete_confirmation = 'stocks';
        $delete_ids = $request->except('_token');

        $products = Stock::whereIn('id', $delete_ids)->get();

        if($products->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
                'products' => $products,
            ]);            
        }
        else {
            return redirect('stocks')->with('message', 'You need to select products first !');
        }
    }

    public function delete_stock_products(Request $request){
        $delete_ids = $request->except('_token');
        $entries_deleted = 0;
        
        foreach($delete_ids as $id){
            /**
             *  remove quantity from total stocks and modify must_buy */

            //Stocks variables:
            $stocks_product = Stock::find($id);
            $command_id = $stocks_product->command_id;
            $stock_quantity = $stocks_product->quantity;

            //Commands variables:
            $commands_product = Command::find($command_id);
            $command_quantity = $commands_product->quantity;
            $alert_stock = $commands_product->alert_stock;
            $newquantity = $command_quantity - $stock_quantity;
            if($newquantity <= $alert_stock){
                $must_buy = 1;
            }
            else {
                $must_buy = 0;
            }

            //Update commands:
            $commands_product->update([
                'quantity' => $newquantity,
                'must_buy' => $must_buy,
            ]);
            
            /** 
             * remove product from stocks */
            $stocks_product->delete();

            $entries_deleted += 1;
        }

        if($entries_deleted == 1){
            return redirect('stocks')->with('success', $entries_deleted . ' entry deleted !');
        }
        elseif($entries_deleted > 1){
            return redirect('stocks')->with('success', $entries_deleted . ' entries deleted !');
        }
        else {
            return redirect('stocks')->with('error', 'There is an error, no entry deleted !');
        }
        
    }

    /**Total-stocks */
    public function show_total_stocks() {
        $products = Command::all();

        return view('total-stocks', [
            'products' => $products,
        ]);
    }

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
