<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Recipe;
use App\Models\Dish;
use App\Rules\RecipeIdValided;
use App\Rules\IdValided;

class MenuController extends Controller
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

        $menus = Menu::where('user_id', $user_id)->orderBy('day', 'asc')->get();

        return view('menus', [
            'menus' => $menus,
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
        $recipes = Recipe::where('user_id', $user_id)->orderBy('name')->get();

        //Get user moment option, transform JSON to Array (amodif)
        $moments = Dish::MOMENTS;

        return view('menu', [
            'is_creating' => $is_creating,
            'recipes' => $recipes,
            'moments' => $moments,
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
            'day' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            '*.*.recipe' => [new RecipeIdValided],
            '*.*.portion' => ['min:0', 'max:1000000000', 'integer'],
        ]);

        //Store menu
        $day = $request->day;

        $menu = Menu::create([
            'day' => $day,
            'user_id' => $user_id,
        ]);

        //Loop through moments of the day
        $moments = $request->except('day', '_token');

        foreach($moments as $moment => $moment_dishes){
            foreach($moment_dishes as $moment_dish){
                if(!empty($moment_dish)){
                    $menu->dishes()->create([
                        'moment' => $moment,
                        'recipe_id' => $moment_dish['recipe'],
                        'portion' => $moment_dish['portion'],
                        'user_id' => $user_id,
                    ]);
                }
            }
        }

        return redirect('menus')->with('success', 'Menu added !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_id = Auth::user()->id;

        $menu = Menu::where([
            'id' => $id,
            'user_id' => $user_id,
        ])->first();

        if(empty($menu)){
            return redirect('menus')->with('error', "This menu doesn't exist");
        }

        //Get user moment option, transform JSON to Array (amodif)
        $option_moments = Dish::MOMENTS;

        foreach($option_moments as $moment => $displayed_moment){
            $moment_dishes = $menu->dishes->where('moment', $moment);
            /**
             * Return the data in an associative array, key is the moment, 
             * and the values are the displayable value for moment and the dishes
             * */
            $moments[$moment] = array($displayed_moment, $moment_dishes);
        }

        return view('menu', [
            'menu' => $menu,
            'moments' => $moments,
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
        $user_id = Auth::user()->id;

        $menu = Menu::where([
            'id' => $id,
            'user_id' => $user_id,
        ])->first();

        $recipes = Recipe::where('user_id', $user_id)->orderBy('name')->get();

        if(empty($menu)){
            return redirect('menus')->with('error', "This menu doesn't exist");
        }

        //Get user moment option, transform JSON to Array (amodif)
        $option_moments = Dish::MOMENTS;

        foreach($option_moments as $moment => $displayed_moment){
            $moment_dishes = $menu->dishes->where('moment', $moment);
            /**
             * Return the data in an associative array, key is the moment, 
             * and the values are the displayable value for moment and the dishes
             * */
            $moments[$moment] = array($displayed_moment, $moment_dishes);
        }

        $is_editing = true;

        return view('menu', [
            'is_editing' => $is_editing,
            'menu' => $menu,
            'moments' => $moments,
            'recipes' => $recipes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_id = Auth::user()->id;

        $request->validate([
            'day' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            '*.*.recipe' => [new RecipeIdValided],
            '*.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            '*.*.id' => ['sometimes', new IdValided],
        ]);

        //Update menu
        $menu = Menu::where([
            'id' => $id,
            'user_id' => $user_id,
        ])->first();

        $menu->update([
            'day' => $request->day,
            'user_id' => $user_id,
        ]);

        //return list of current existing ids for this menu in dishes
        $old_menu_dishes = Dish::where([
            'menu_id' => $id,
            'user_id' => $user_id,
        ])->get();


        //Loop through moments of the day
        $moments = $request->except('day', '_token');
        foreach($moments as $moment => $moment_dishes){
            //For each moment loop through dishes
            foreach($moment_dishes as $moment_dish){
                //Check if dish is in dishes array
                $existing_dish = '';
                if(!empty($moment_dish['id'])){
                    $existing_dish = Dish::where([
                        'id' => $moment_dish['id'],
                        'user_id' => $user_id,
                    ])->first();
                }
                $moment_dish_recipe_id = $moment_dish['recipe'];
                $moment_dish_portion = $moment_dish['portion'];
                
                if(!empty($existing_dish)){
                    $existing_dish->update([
                        'recipe_id' => $moment_dish_recipe_id,
                        'portion' => $moment_dish_portion,
                    ]);
                }
                else {
                    Dish::create([
                        'menu_id' => $id,
                        'moment' => $moment,
                        'recipe_id' => $moment_dish_recipe_id,
                        'portion' => $moment_dish_portion,
                        'user_id' => $user_id,
                    ]);
                };
                //Add dish id to array
                if (!empty($moment_dish['id'])) {
                    $new_dishes_array[] = $moment_dish['id'];
                } 
            }
        }

        //Delete dishes if they don't exist anymore:
        foreach($old_menu_dishes as $old_menu_dish){
            $old_dish_id = $old_menu_dish->id;
            if(!in_array($old_dish_id, $new_dishes_array)){
                $old_dish = Dish::where([
                    'id' => $old_dish_id,
                    'user_id' => $user_id,
                ])->delete();
            }
        }

        return redirect('menu/show/'.$id)->with('success', 'Menu updated !');
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

        $delete_confirmation = 'menus';
        $delete_ids = $request->except('_token');

        $menus = Menu::where('user_id', $user_id)->whereIn('id', $delete_ids)->get();

        if($menus->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
                'menus' => $menus,
            ]);            
        }

        return redirect('menus')->with('message', 'You need to select menus first !');
    }

    /**
     * Remove the specified resources from storage.
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

        foreach($delete_ids as $deleted_id){

            $menu = Menu::where([
                'id' => $deleted_id,
                'user_id' => $user_id,
            ])->first();

            if(!empty($menu)){
                $menu->delete();
                
                $entries_deleted += 1;
            }  
        }

        redirectWithDeletionMessage($entries_deleted, $entries_total, 'menus');
    }
}
