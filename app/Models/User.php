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

    protected $table = 'user';
    protected $guarded = [];

    public function gender()
    {
        // user many-to-one [gender]
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function role()
    {
        // user many-to-one [role]
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function cart()
    {
        // user one-to-one [cart]
        return $this->hasOne(Cart::class, 'user_id');
    }

    public function transactions()
    {
        // user one-to-many [transaction]
        return $this->hasMany(Transaction::class, 'user_id');
    }
}
