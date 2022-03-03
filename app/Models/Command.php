<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient', 'quantity', 'unit', 'alert_stock', 'must_buy', 'user_id'];

    public $timestamps = false;

    public function stocks(){
        return $this->hasMany(Stock::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
