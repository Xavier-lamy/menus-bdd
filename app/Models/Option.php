<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;

    protected $fillable = ['option_type', 'options'];

    //Define the basics options of the website
    public const STARTING_OPTIONS = [
        [
            'id' => 1,
            'option_type' => 'dish_moments',
            'options' => array('morning' => 'Breakfast', 'noon' => 'Lunch', 'evening' => 'Dinner'),
        ],
        [
            'id' => 2,
            'option_type' => 'dish_moments',
            'options' => array('daily_production' => 'Daily Production'),
        ],
        [
            'id' => 3,
            'option_type' => 'commands_created',
            'options' => array('true' => 'Commands products already created', 'false' => 'No commands products created yet'),
        ],
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('active');
    }
}
