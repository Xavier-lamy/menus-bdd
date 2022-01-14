<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;
use App\Models\Command;

class Quantity extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'command_id', 'recipe_id'];

    public $timestamps = false;

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }

    public function ingredientUnit(){
        return $this->belongsTo(Command::class);
    }
}
