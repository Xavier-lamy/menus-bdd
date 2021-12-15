<?php

namespace App\Models;

use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function command(){
        return $this->belongsTo(Command::class);
    }
}
