<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'user_id'];

    public $timestamps = false;

    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
