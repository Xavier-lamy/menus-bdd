<?php

/**
 * Contains the custom functions for the application
 */
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Database\Seeders\AppSeeders\CommandSeeder;

if (!function_exists('checkProductExpire')) {
    /**
     * Take a date as a string and return a suffix
     * depending on the difference with the current date
     *
     * @param string $date
     *
     * @return string $class_suffix
     */
    function checkProductExpire($date)
    {
        $current = Carbon::now()->format('Y-m-d');
        //Force correct format for returned date:
        $date = Carbon::createFromFormat('Y-m-d', $date);
        $diffInDays = $date->diffInDays($current);

        if ($date->lt($current)) {
            return $class_sufix='-warning';
        } elseif ($diffInDays <= 10 && $diffInDays >= 1) {
            return $class_sufix='-message';
        }
    
        return $class_sufix='-success';
    }
}

if (!function_exists('redirectWithDeletionMessage')){
    /**
     * Display the deletion message and redirect to the selected route
     * 
     * @param int $entries_deleted
     * @param int $entries_total
     * @param string $route_name
     * 
     * @return redirect to the view
     * @return string $error | $success
     */
    function redirectWithDeletionMessage($entries_deleted, $entries_total, $route_name)
    {
        $difference = $entries_total - $entries_deleted;
        switch($entries_deleted){
            case 0:
                return redirect($route_name)->with('error', "There is an error, no entry deleted")->send();
            case 1:
                if($entries_total != $entries_deleted){
                    return redirect($route_name)->with('success', "{$entries_deleted} entry deleted, {$difference} couldn't be deleted")->send(); 
                }
                return redirect($route_name)->with('success', "{$entries_deleted} entry deleted !")->send();
            default:
                if($entries_total != $entries_deleted){
                    return redirect($route_name)->with('success', "{$entries_deleted} entries deleted, {$difference} couldn't be deleted")->send(); 
                } 
                return redirect($route_name)->with('success', "{$entries_deleted} entries deleted !")->send(); 
        }
    }
}

if( !function_exists('createBasicIngredients')){
    /**
     * Seed the database for a user with some common ingredients
     * 
     * @param int $userId
     * 
     * @return void
     */
    function createBasicIngredients(int $userId): void
    {
        CommandSeeder::seedApp($userId);
    }
}