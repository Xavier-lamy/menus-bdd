<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Recipe;

class Dish extends Model
{
    use HasFactory;

    public const MEAL_TIME = ['morning', 'noon', 'evening'];

    protected $fillable = ['menu_id', 'meal_time', 'recipe_id', 'portion'];

    public $timestamps = false;

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id');
    }

    public function recipe()
    {
        return $this->hasOne(Recipe::class);
    }
}
