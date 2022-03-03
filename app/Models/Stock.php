<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Command;
use App\Models\User;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'useby_date', 'command_id', 'user_id'];

    public $timestamps = false;

    public function command(){
        return $this->belongsTo(Command::class, 'command_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
