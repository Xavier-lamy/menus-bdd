<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
