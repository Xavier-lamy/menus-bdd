<?php

namespace App\Http\Controllers;

use App\Models\Command;
use App\Models\Stock;
use Illuminate\Http\Request;

class DeleteController extends Controller
{
    //Stocks
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
        $entries_total = count($delete_ids);
        
        foreach($delete_ids as $id){
            /**
             *  remove quantity from total stocks and modify must_buy */

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
                
                /** 
                 * remove product from stocks */
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

    //Commands
    public function delete_command_products_confirmation(Request $request){
        $delete_confirmation = 'commands';
        $delete_ids = $request->except('_token');

        $products = Command::whereIn('id', $delete_ids)->get();

        if($products->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
                'products' => $products,
            ]);            
        }
        else {
            return redirect('total-stocks')->with('message', 'You need to select products first !');
        }
    }

    public function delete_command_products(Request $request){
        $delete_ids = $request->except('_token');
        $entries_deleted = 0;
        $entries_total = count($delete_ids);
        
        foreach($delete_ids as $delete_id){
            
            $commands_product = Command::find($delete_id);

            if(!empty($commands_product)){
                //remove entry from total stocks (and stocks cascade delete)
                $commands_product->delete();
                
                $entries_deleted += 1;                
            }
            else {
                $entries_deleted += 0;
            }
        }

        if($entries_total != $entries_deleted){
            $difference = $entries_total - $entries_deleted;
            if($entries_deleted == 1){
                return redirect('total-stocks')->with('success', "{$entries_deleted} entry deleted, {$difference} couldn't be deleted");
            }
            elseif($entries_deleted > 1){
                return redirect('total-stocks')->with('success', "{$entries_deleted} entries deleted, {$difference} couldn't be deleted");
            }
            elseif($entries_deleted == 0) {
                return redirect('total-stocks')->with('error', "There is an error, no entry deleted");
            }
        }
        else {
            if($entries_deleted == 1){
                return redirect('total-stocks')->with('success', "{$entries_deleted} entry deleted !");
            }
            elseif($entries_deleted > 1){
                return redirect('total-stocks')->with('success', "{$entries_deleted} entries deleted !");
            }
            elseif($entries_deleted == 0){
                return redirect('total-stocks')->with('error', "There is an error, no entry deleted !");
            }            
        }
    }
}
