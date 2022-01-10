<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\Stock;
use App\Rules\CommandIdValided;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Stock::all();
        
        return view('stocks', [
            'products' => $products,
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_creating = true;
        $products = Stock::all();
        $commands_products = Command::orderBy('ingredient')->get();

        return view('stocks', [
            'products' => $products,
            'commands_products' => $commands_products,
            'is_creating' => $is_creating,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not used for now 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Stock::all();

        return view('stocks', [
            'products' => $products,
            'modifying_product_id' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => ['required', 'min:0', 'integer'],
            'command_id' => ['required', 'min:0', 'integer'],
            'useby_date' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'quantity' => ['required', 'min:0', 'integer'],
        ]);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirm_destroy(Request $request)
    {
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

        /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $delete_ids = $request->except('_token');
        $entries_deleted = 0;
        $entries_total = count($delete_ids);
        
        foreach($delete_ids as $id){

        //remove quantity from total stocks and modify must_buy

            //Stocks variables:
            $stocks_product = Stock::find($id);

            if(!empty($stocks_product)){
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
                
        //remove product from stocks
                $stocks_product->delete();

                $entries_deleted += 1;                
            }
            else {
                $entries_deleted += 0;
            }
        }

        if($entries_total != $entries_deleted){
            $difference = $entries_total - $entries_deleted;
            if($entries_deleted == 1){
                return redirect('stocks')->with('success', "{$entries_deleted} entry deleted, {$difference} couldn't be deleted");
            }
            elseif($entries_deleted > 1){
                return redirect('stocks')->with('success', "{$entries_deleted} entries deleted, {$difference} couldn't be deleted");
            }
            elseif($entries_deleted == 0) {
                return redirect('stocks')->with('error', "There is an error, no entry deleted");
            }
        }
        else {
            if($entries_deleted == 1){
                return redirect('stocks')->with('success', "{$entries_deleted} entry deleted !");
            }
            elseif($entries_deleted > 1){
                return redirect('stocks')->with('success', "{$entries_deleted} entries deleted !");
            }
            elseif($entries_deleted == 0){
                return redirect('stocks')->with('error', "There is an error, no entry deleted !");
            }            
        }
    }
}
