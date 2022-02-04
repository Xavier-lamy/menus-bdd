<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Recipe;
use App\Rules\RecipeIdValided;

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

        $morning = array();
        $noon = array();
        $evening = array();

        if (!empty($request->morning)) {
            foreach ($request->morning as $morning_recipe) {
                $morning += [$morning_recipe['recipe'] => $morning_recipe['portion']];
            };
        }

        if (!empty($request->noon)) {
            foreach ($request->noon as $noon_recipe) {
                $noon += [$noon_recipe['recipe'] => $noon_recipe['portion']];
            };
        }

        if (!empty($request->evening)) {
            foreach ($request->evening as $evening_recipe) {
                $evening += [$evening_recipe['recipe'] => $evening_recipe['portion']];
            };
        }

        $day = $request->day;

        Menu::create([
            'day' => $day,
            'morning' => $morning,
            'noon' => $noon,
            'evening' => $evening,
        ]);

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

        //fetch recipes for morning
        $morning = $menu->morning;
        $morning_keys = array_keys($morning);

        $morning_recipes = Recipe::whereIn('id', $morning_keys)->get();

        //fetch recipes for noon
        $noon = $menu->noon;
        $noon_keys = array_keys($noon);

        $noon_recipes = Recipe::whereIn('id', $noon_keys)->get();

        //fetch recipes for evening
        $evening = $menu->evening;
        $evening_keys = array_keys($evening);

        $evening_recipes = Recipe::whereIn('id', $evening_keys)->get();

        return view('menu', [
            'menu' => $menu,
            'morning_recipes' => $morning_recipes,
            'noon_recipes' => $noon_recipes,
            'evening_recipes' => $evening_recipes,
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

        $is_editing = true;

        return view('menu', [
            'is_editing' => $is_editing,
            'menu' => $menu,
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
