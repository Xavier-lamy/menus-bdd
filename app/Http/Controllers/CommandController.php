<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Command;
use Illuminate\Support\Facades\Auth;

class CommandController extends Controller
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

        $products = Command::where('user_id', $user_id)->get();

        return view('commands', [
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
        $products = Command::where('user_id', $user_id)->get();

        return view('commands', [
            'products' => $products,
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
            'ingredient' => ['required', 'min:1', 'max:40', 'string'],
            'unit' => ['required', 'min:1', 'max:30', 'string'],
            'alert_stock' => ['required', 'min:0', 'max:1000000000', 'integer'],
        ]);

        $ingredient = strtolower($request->ingredient);
        $unit = strtolower($request->unit);
        $alert_stock = $request->alert_stock;
        $product_exist = Command::where([
            'ingredient' => $ingredient,
            'unit' => $unit,
            'user_id' => $user_id,
        ])->first();

        if(!empty($product_exist)){
            return redirect('commands')->with('message', "Product: {$ingredient} ({$unit}),already exists !");
        }

        Command::create([
            'ingredient' => $ingredient,
            'quantity' => 0,
            'unit' => $unit,
            'alert_stock' => $alert_stock,
            'must_buy' => 1,
            'user_id' => $user_id,
        ]);

        return redirect('commands')->with('success', 'Product successfully added !');            
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

        $products = Command::where('user_id', $user_id)->get();

        return view('commands', [
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
            'ingredient' => ['required', 'min:1', 'max:40', 'string'],
            'unit' => ['required', 'min:1', 'max:30', 'string'],
            'alert_stock' => ['required', 'min:0', 'max:1000000000', 'integer'],
        ]);

        //Modify commands: ingredient, unit and alert-stock
        $command_id = $request->id;
        $commands_product = Command::where([
            'id' => $command_id,
            'user_id'=> $user_id,
        ])->first();

        $command_ingredient = strtolower($request->ingredient);
        $command_unit = strtolower($request->unit);
        $command_alert_stock = $request->alert_stock;

        $commands_product->update([
            'ingredient' => $command_ingredient,
            'unit' => $command_unit,
            'alert_stock' => $command_alert_stock,
        ]);

        //Check if must_buy
        $new_commands_product = Command::where([
            'id' => $command_id,
            'user_id'=> $user_id,
        ])->first();
        
        $new_command_quantity = $new_commands_product->quantity;
        $new_alert_stock = $new_commands_product->alert_stock;
        $must_buy = 0;

        if($new_command_quantity <= $new_alert_stock){
            $must_buy = 1;
        }

        //Update commands:
        $new_commands_product->update([
            'must_buy' => $must_buy,
        ]);
        
        return redirect('commands')->with('success', 'Product modified !');
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

        $delete_confirmation = 'commands';
        $delete_ids = $request->except('_token');

        $products = Command::where('user_id', $user_id)->whereIn('id', $delete_ids)->get();

        if($products->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
                'products' => $products,
            ]);            
        }

        return redirect('commands')->with('message', 'You need to select products first !');

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
        
        foreach($delete_ids as $delete_id){
            
            $commands_product = Command::where([
                'id' => $delete_id,
                'user_id' => $user_id,
            ])->first();

            if(!empty($commands_product)){
                //remove entry from total stocks (and stocks cascade delete)
                $commands_product->delete();
                
                $entries_deleted += 1;                
            }
        }
        redirectWithDeletionMessage($entries_deleted, $entries_total, 'commands');
    }
}
