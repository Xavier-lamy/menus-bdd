<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'morning', 'noon', 'evening'];

    public $timestamps = false;

    protected $casts = [
        'morning' => 'array',
        'noon' => 'array',
        'evening' => 'array',
    ];
}
