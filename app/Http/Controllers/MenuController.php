<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Rules\CommandIdValided;
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
        return view('menus');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $is_creating = true;

        return view('menu', [
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
            'day' => ['required', 'date_format:Y-m-d', 'after:2000-01-01', 'before:2300-01-01'],
            'morning.*.recipe' => [new RecipeIdValided],
            'morning.*.quantity' => ['min:0', 'max:1000000000', 'integer'],
            'noon.*.recipe' => [new RecipeIdValided],
            'noon.*.quantity' => ['min:0', 'max:1000000000', 'integer'],
            'evening.*.recipe' => [new RecipeIdValided],
            'evening.*.quantity' => ['min:0', 'max:1000000000', 'integer'],
        ]);

        $morning = array();
        $noon = array();
        $evening = array();

        foreach($request->morning as $morning_recipe){
            $morning += [$morning_recipe['recipe'] => $morning_recipe['quantity']];
        };

        foreach($request->noon as $noon_recipe){
            $noon += [$noon_recipe['recipe'] => $noon_recipe['quantity']];
        };

        foreach($request->evening as $evening_recipe){
            $evening += [$evening_recipe['recipe'] => $evening_recipe['quantity']];
        };

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
        return view('menu', [
            //
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
        $is_editing = true;

        return view('menu', [
            'is_editing' => $is_editing,
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
        return redirect('recipe/show/'.$id)->with('success', 'Menu updated !');
    }

    /**
     * Ask the user before removing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmDestroy(Request $request)
    {
/*         $delete_confirmation = 'menus';
        $delete_ids = $request->except('_token'); */

/*         $recipes = Menu::whereIn('id', $delete_ids)->get(); */

/*         if($recipes->count() > 0){
            return view('confirmation', [
                'delete_confirmation' => $delete_confirmation,
            ]);            
        } */

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
        /*         $delete_ids = $request->except('_token');
                $entries_deleted = 0;
                $entries_total = count($delete_ids); */
        
        /*         foreach($delete_ids as $deleted_id){


                    $entries_deleted += 1;
                } */

        /*         $difference = $entries_total - $entries_deleted;
                switch($entries_deleted){
                    case 0:
                        return redirect('recipes')->with('error', "There is an error, no entry deleted");
                    case 1:
                        if($entries_total != $entries_deleted){
                            return redirect('recipes')->with('success', "{$entries_deleted} entry deleted, {$difference} couldn't be deleted");
                        }
                        return redirect('recipes')->with('success', "{$entries_deleted} entry deleted !");
                    default:
                        if($entries_total != $entries_deleted){
                            return redirect('recipes')->with('success', "{$entries_deleted} entries deleted, {$difference} couldn't be deleted");
                        }
                        return redirect('recipes')->with('success', "{$entries_deleted} entries deleted !");
                } */

        return redirect('recipes')->with('error', "There is an error, no entry deleted");
    }
}
