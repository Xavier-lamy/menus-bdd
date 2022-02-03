<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class RecipeIdValided implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!empty($value) && is_numeric($value) && $value >= 1){
            return true;
        }
        
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Recipe doesn\'t exist';
    }
}
