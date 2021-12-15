<?php

namespace App\Models;

use App\Models\Command;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient', 'quantity', 'quantity_name', 'useby_date', 'commands_id'];

    public $timestamps = false;

    public function command(){
        return $this->belongsTo(Command::class, 'commands_id');
    }
}
