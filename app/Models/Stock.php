<?php

namespace App\Models;

use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'useby_date', 'command_id'];

    public $timestamps = false;

    public function command(){
        return $this->belongsTo(Command::class, 'command_id', 'id');
    }
}
