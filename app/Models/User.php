<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function commands()
    {
        return $this->hasMany(Command::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    public function dishes()
    {
        return $this->hasManyThrough(Dish::class, Menu::class);
    }

    public function quantities()
    {
        return $this->hasManyThrough(Quantity::class, Recipe::class);
    }

    public function options()
    {
        return $this->belongsToMany(Option::class)->withPivot('active');
    }
}
