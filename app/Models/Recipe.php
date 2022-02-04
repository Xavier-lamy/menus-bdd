<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quantity;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'process', 'total'];

    public $timestamps = false;

    public function quantities(){
        return $this->hasMany(Quantity::class);
    }
}
