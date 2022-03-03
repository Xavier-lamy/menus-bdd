<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Recipe;
use App\Models\Command;
use App\Models\User;

class Quantity extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'command_id', 'recipe_id', 'user_id'];

    public $timestamps = false;

    public function recipe(){
        return $this->belongsTo(Recipe::class);
    }

    public function command(){
        return $this->belongsTo(Command::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
