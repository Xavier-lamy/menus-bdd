<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Quantity;
use App\Models\Command;
use App\Rules\CommandIdValided;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::all();

        return view('recipes', [
            'recipes' => $recipes,            
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
        $commands_products = Command::orderBy('ingredient')->get();
        return view('recipe', [
            'is_creating' => $is_creating,
            'commands_products' => $commands_products,
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
            'recipe_name' => ['required', 'min:1', 'max:120', 'string'],
            'ingredient.*.command_id' => [new CommandIdValided],
            'ingredient.*.quantity' => ['required', 'min:0', 'max:1000000000', 'integer'],
            'process' => ['required', 'min:1', 'max:1000000', 'string']
        ]);

        $recipe_name = $request->recipe_name;
        $ingredients = $request->ingredient;
        $process = $request-> process;

        //Check if all ingredients have same unit
        foreach( $ingredients as $ingredient ){
            $command_id = $ingredient['command_id'];
            $product = Command::find($command_id);
            $product_unit = $product->unit;
            if( !isset($first_product_unit) ){
                $first_product_unit = $product->unit;
                continue;
            };
            if( $product_unit != $first_product_unit ){
                return redirect('recipe/create')->with('error', 'All ingredients should have same unit !');
            };
        };

        //Count recipe total weight
        $total_weight = 0;
        foreach( $ingredients as $ingredient ){
            $total_weight += $ingredient['quantity'];
        }

        //Store the new recipe
        $new_recipe = Recipe::create([
            'name' => $recipe_name,
            'process' => $process,
            'total_weight' => $total_weight,
        ]);

        //Store the ingredients
        $recipe_id = $new_recipe->id;

        foreach ( $ingredients as $ingredient){
            Quantity::create([
                'command_id' => $ingredient['command_id'],
                'quantity' => $ingredient['quantity'],
                'recipe_id' => $recipe_id,
            ]);
        }
        
        return redirect('recipes')->with('success', 'Recipe created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $recipe = Recipe::find($id);

        $quantities = Quantity::where('recipe_id', $id)->get();

        return view('recipe', [
            'recipe' => $recipe,
            'quantities' => $quantities,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $recipe = Recipe::find($id);

        $is_editing = true;
        return view('recipe', [
            'recipe' => $recipe,
            'is_editing' => $is_editing,
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
        return redirect('recipe')->with('success', 'Recipe updated !');
    }

    /**
     * Ask the user before removing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request)
    {
        $delete_confirmation = 'recipes';
        //...

        return redirect('recipes')->with('message', 'You need to select recipes first !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //...
        return redirect('recipes')->with('error', "There is an error, no entry deleted");
    }
}
