<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    //Stocks
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

    //Commands
    public function modify_command_product($id) {

        //Amodif
        $products = Command::all();

        return view('total-stocks', [
            'products' => $products,
            'modifying_product_id' => $id,
        ]);
    }

    public function apply_command_product_modifications(Request $request) {

        //Modify commands: ingredient, unit and alert-stock
        $command_id = $request->id;
        $commands_product = Command::find($command_id);
        $command_ingredient = $request->ingredient;
        $command_quantity_name = $request->quantity_name;
        $command_alert_stock = $request->alert_stock;

        $commands_product->update([
            'ingredient' => $command_ingredient,
            'quantity_name' => $command_quantity_name,
            'alert_stock' => $command_alert_stock,
        ]);

        //Check if must_buy
        $new_commands_product = Command::find($command_id);
        $new_command_quantity = $new_commands_product->quantity;
        $new_command_alert_stock = $new_commands_product->alert_stock;
        if($new_command_quantity <= $new_command_alert_stock){
            $must_buy = 1;
        }
        else {
            $must_buy = 0;
        }
        //Update commands:
        $new_commands_product->update([
            'must_buy' => $must_buy,
        ]);

        //Modify related stock products ingredient name and unit
        Stock::where('command_id', $command_id)->update([
            'ingredient' => $command_ingredient,
            'quantity_name' => $command_quantity_name,
        ]);
        
        return redirect('total-stocks')->with('success', 'Product modified !');
    }
}
