<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quantity;
use App\Models\User;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'process', 'total', 'user_id'];

    public $timestamps = false;

    public function quantities(){
        return $this->hasMany(Quantity::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
