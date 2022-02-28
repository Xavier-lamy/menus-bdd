<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Recipe;
use App\Models\Dish;
use App\Rules\RecipeIdValided;
use App\Rules\DishIdValided;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::orderBy('day', 'asc')->get();

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
        $is_creating = true;
        $recipes = Recipe::orderBy('name')->get();

        return view('menu', [
            'is_creating' => $is_creating,
            'recipes' => $recipes,
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
            'day' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'morning.*.recipe' => [new RecipeIdValided],
            'morning.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            'noon.*.recipe' => [new RecipeIdValided],
            'noon.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            'evening.*.recipe' => [new RecipeIdValided],
            'evening.*.portion' => ['min:0', 'max:1000000000', 'integer'],
        ]);

        //Store menu
        $day = $request->day;

        $menu = Menu::create([
            'day' => $day,
        ]);

        if (!empty($request->morning)) {
            foreach ($request->morning as $morning_dish) {
                $menu->dishes()->create([
                    'meal_time' => 'morning',
                    'recipe_id' => $morning_dish['recipe'],
                    'portion' => $morning_dish['portion'],
                ]);
            };
        }

        if (!empty($request->noon)) {
            foreach ($request->noon as $noon_dish) {
                $menu->dishes()->create([
                    'meal_time' => 'noon',
                    'recipe_id' => $noon_dish['recipe'],
                    'portion' => $noon_dish['portion'],
                ]);
            };
        }

        if (!empty($request->evening)) {
            foreach ($request->evening as $evening_dish) {
                $menu->dishes()->create([
                    'meal_time' => 'evening',
                    'recipe_id' => $evening_dish['recipe'],
                    'portion' => $evening_dish['portion'],
                ]);
            };
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
        $menu = Menu::find($id);

        if(empty($menu)){
            return redirect('menus')->with('error', "This menu doesn't exist");
        }

        //fetch dishes for morning
        $morning_dishes = $menu->dishes->where('meal_time', 'morning');

        //fetch dishes for noon
        $noon_dishes = $menu->dishes->where('meal_time', 'noon');

        //fetch dishes for evening
        $evening_dishes = $menu->dishes->where('meal_time', 'evening');

        return view('menu', [
            'menu' => $menu,
            'morning_dishes' => $morning_dishes,
            'noon_dishes' => $noon_dishes,
            'evening_dishes' => $evening_dishes,
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
        $menu = Menu::find($id);
        $recipes = Recipe::orderBy('name')->get();

        if(empty($menu)){
            return redirect('menus')->with('error', "This menu doesn't exist");
        }

        //fetch dishes for morning
        $morning_dishes = $menu->dishes->where('meal_time', 'morning');

        //fetch dishes for noon
        $noon_dishes = $menu->dishes->where('meal_time', 'noon');

        //fetch dishes for evening
        $evening_dishes = $menu->dishes->where('meal_time', 'evening');

        $is_editing = true;

        return view('menu', [
            'is_editing' => $is_editing,
            'menu' => $menu,
            'morning_dishes' => $morning_dishes,
            'noon_dishes' => $noon_dishes,
            'evening_dishes' => $evening_dishes,
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
        $request->validate([
            'day' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'morning.*.recipe' => [new RecipeIdValided],
            'morning.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            'morning.*.id' => ['sometimes', new DishIdValided],
            'noon.*.recipe' => [new RecipeIdValided],
            'noon.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            'noon.*.id' => ['sometimes', new DishIdValided],
            'evening.*.recipe' => [new RecipeIdValided],
            'evening.*.portion' => ['min:0', 'max:1000000000', 'integer'],
            'evening.*.id' => ['sometimes', new DishIdValided],
        ]);

        //Update menu
        $menu = Menu::find($id);
        $menu->update([
            'day' => $request->day,
        ]);

        //return list of current existing ids for this menu in dishes
        $old_menu_dishes = Dish::where('menu_id', $id)->get();

        /**
         * For morning
         */
        foreach($request->morning as $morning){
            //Check if dish is in dishes array
            $morning_dish = '';
            if(!empty($morning['id'])){
                $morning_dish = Dish::find($morning['id']);
            }
            $morning_recipe_id = $morning['recipe'];
            $morning_portion = $morning['portion'];
            
            if(!empty($morning_dish)){
                $morning_dish->update([
                    'recipe_id' => $morning_recipe_id,
                    'portion' => $morning_portion,
                ]);
            }
            else {
                Dish::create([
                    'menu_id' => $id,
                    'meal_time' => 'morning',
                    'recipe_id' => $morning_recipe_id,
                    'portion' => $morning_portion,
                ]);
            };
            //Add dish id to array
            if (!empty($morning['id'])) {
                $new_dishes_array[] = $morning['id'];
            } 
        };


        /**
         * For noon
         */
        foreach($request->noon as $noon){
            //Check if dish is in dishes array
            $noon_dish = '';
            if(!empty($noon['id'])){
                $noon_dish = Dish::find($noon['id']);
            }
            $noon_recipe_id = $noon['recipe'];
            $noon_portion = $noon['portion'];
            if(!empty($noon_dish)){
                $noon_dish->update([
                    'recipe_id' => $noon_recipe_id,
                    'portion' => $noon_portion,
                ]);
            }
            else {
                Dish::create([
                    'menu_id' => $id,
                    'meal_time' => 'noon',
                    'recipe_id' => $noon_recipe_id,
                    'portion' => $noon_portion,
                ]);
            };
            //Add dish id to array
            if (!empty($noon['id'])) {
                $new_dishes_array[] = $noon['id'];
            } 
        };

        /**
         * For evening
         */
        foreach($request->evening as $evening){
            //Check if dish is in dishes array
            $evening_dish = '';
            if(!empty($evening['id'])){
                $evening_dish = Dish::find($evening['id']);
            }
            $evening_recipe_id = $evening['recipe'];
            $evening_portion = $evening['portion'];
            
            if(!empty($evening_dish)){
                $evening_dish->update([
                    'recipe_id' => $evening_recipe_id,
                    'portion' => $evening_portion,
                ]);
            }
            else {
                Dish::create([
                    'menu_id' => $id,
                    'meal_time' => 'evening',
                    'recipe_id' => $evening_recipe_id,
                    'portion' => $evening_portion,
                ]);
            };
            //Add dish id to array
            if (!empty($evening['id'])) {
                $new_dishes_array[] = $evening['id'];
            }
        };

        //Delete dishes if they don't exist anymore:
        foreach($old_menu_dishes as $old_menu_dish){
            $old_dish_id = $old_menu_dish->id;
            if(!in_array($old_dish_id, $new_dishes_array)){
                $old_dish = Dish::find($old_dish_id)->delete();
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
        $delete_confirmation = 'menus';
        $delete_ids = $request->except('_token');

        $menus = Menu::whereIn('id', $delete_ids)->get();

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
        $delete_ids = $request->except('_token');
        $entries_deleted = 0;
        $entries_total = count($delete_ids);

        foreach($delete_ids as $deleted_id){

            $menu = Menu::find($deleted_id);

            if(!empty($menu)){
                $menu->delete();
                
                $entries_deleted += 1;
            }  
        }

        $difference = $entries_total - $entries_deleted;
        switch($entries_deleted){
            case 0:
                return redirect('menus')->with('error', "There is an error, no entry deleted");
            case 1:
                if($entries_total != $entries_deleted){
                    return redirect('menus')->with('success', "{$entries_deleted} entry deleted, {$difference} couldn't be deleted");
                }
                return redirect('menus')->with('success', "{$entries_deleted} entry deleted !");
            default:
                if($entries_total != $entries_deleted){
                    return redirect('menus')->with('success', "{$entries_deleted} entries deleted, {$difference} couldn't be deleted");
                }
                return redirect('menus')->with('success', "{$entries_deleted} entries deleted !");
        }
    }
}
