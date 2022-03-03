<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use App\Models\Stock;
use App\Rules\CommandIdValided;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    /**
     * Define middlewares in class construct
     */
    public function __construct() {
        //Force use of authentication
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $user_id = Auth::user()->id;

        $products = Stock::where('user_id', $user_id)->get();
        
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
        $user_id = Auth::user()->id;

        $is_creating = true;
        $products = Stock::where('user_id', $user_id)->get();

        $commands_products = Command::where('user_id', $user_id)
            ->orderBy('ingredient')
            ->get();

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
        $user_id = Auth::user()->id;

        $request->validate([
            'quantity' => ['required', 'min:0', 'max:1000000000', 'integer'],
            'useby_date' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'command_id' => [new CommandIdValided],
        ]);

        $id = $request->command_id;
        $commands_product = Command::where([
            'id' => $id,
            'user_id' => $user_id,
        ])->first();

        Stock::create([
            'quantity' => $request->quantity,
            'useby_date' => $request->useby_date,
            'command_id' => $id,
            'user_id' => $user_id,
        ]);

        $alert_stock = $commands_product->alert_stock;
        $command_quantity = $commands_product->quantity;
        $stock_quantity = $request->quantity;
        $newquantity = $command_quantity + $stock_quantity;
        $must_buy = 0;

        if($newquantity <= $alert_stock){
            $must_buy = 1;
        }

        $commands_product->update([
            'quantity' => $newquantity,
            'must_buy' => $must_buy,
        ]);

        return redirect('stocks')->with('success', 'New product added to stocks');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_id = Auth::user()->id;

        $products = Stock::where('user_id', $user_id)->get();

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
        $user_id = Auth::user()->id;

        $request->validate([
            'id' => ['required', 'min:0', 'integer'],
            'command_id' => ['required', 'min:0', 'integer'],
            'useby_date' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'quantity' => ['required', 'min:0', 'max:1000000000', 'integer'],
        ]);

        //Fetch data from request
        $stock_id = $request->id;
        $command_id = $request->command_id;
        $stock_quantity = $request->quantity;
        $useby_date = $request->useby_date;
        
        //Fetch ancient value for stock quantity
        $stocks_product = Stock::where([
            'id' => $stock_id,
            'user_id'=> $user_id,
        ])->first();

        $old_stock_quantity = $stocks_product->quantity;

        //update product in stocks
        $stocks_product->update([
            'quantity' => $stock_quantity,
            'useby_date' => $useby_date,
        ]);

        //update product in commands
        $commands_product = Command::where([
            'id' => $command_id,
            'user_id'=> $user_id,
        ])->first();

        $alert_stock = $commands_product->alert_stock;
        $command_quantity = $commands_product->quantity;
        $newquantity = ($command_quantity - $old_stock_quantity) + $stock_quantity;
        $must_buy = 0;

        if($newquantity <= $alert_stock){
            $must_buy = 1;
        }

        $commands_product->update([
            'quantity' => $newquantity,
            'must_buy' => $must_buy,
        ]);

        return redirect('stocks')->with('success', 'Product modified !');
    }

    /**
     * Ask the user before removing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request)
    {
        $user_id = Auth::user()->id;

        $delete_confirmation = 'stocks';
        $delete_ids = $request->except('_token');

        $products = Stock::where('user_id', $user_id)->whereIn('id', $delete_ids)->get();

        if($products->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
                'products' => $products,
            ]);            
        }

        return redirect('stocks')->with('message', 'You need to select products first !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $user_id = Auth::user()->id;

        $delete_ids = $request->except('_token');
        $entries_deleted = 0;
        $entries_total = count($delete_ids);
        
        foreach($delete_ids as $id){

        //remove quantity from total stocks and modify must_buy

            //Stocks variables:
            $stocks_product = Stock::where([
                'id' => $id,
                'user_id'=> $user_id,
            ])->first();

            if(!empty($stocks_product)){
                $command_id = $stocks_product->command_id;
                $stock_quantity = $stocks_product->quantity;

                //Commands variables:
                $commands_product = Command::where([
                    'id' => $command_id,
                    'user_id'=> $user_id,
                ])->first();
                
                $command_quantity = $commands_product->quantity;
                $alert_stock = $commands_product->alert_stock;
                $newquantity = $command_quantity - $stock_quantity;
                $must_buy = 0;

                if($newquantity <= $alert_stock){
                    $must_buy = 1;
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
        }

        redirectWithDeletionMessage($entries_deleted, $entries_total, 'stocks');
    }
}
