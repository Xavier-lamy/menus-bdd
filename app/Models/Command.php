<?php

namespace App\Models;

use App\Models\Stock;
use App\Models\Quantity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = ['ingredient', 'quantity', 'unit', 'alert_stock', 'must_buy'];

    public $timestamps = false;

    public function stocks(){
        return $this->hasMany(Stock::class);
    }
}
