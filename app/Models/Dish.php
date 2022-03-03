<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Recipe;
use App\Models\User;

class Dish extends Model
{
    use HasFactory;

    //Default moment option
    public const MOMENTS = ['morning' => 'Breakfast', 'noon' => 'Lunch', 'evening' => 'Dinner'];

    protected $fillable = ['menu_id', 'moment', 'recipe_id', 'portion', 'user_id'];

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
