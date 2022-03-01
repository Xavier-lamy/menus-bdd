<?php

/**
 * Contains the custom functions for the application
 */
use Carbon\Carbon;

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