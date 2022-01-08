<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'cart';
    protected $guarded = [];

    public function user()
    {
        // [cart] one-to-one user
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keyboards()
    {
        // [cart] many-to-many keyboard
        // [cart] one-to-many cart_keyboard many-to-one keyboard
        return $this->belongsToMany(Keyboard::class, 'cart_keyboard', 'cart_id', 'keyboard_id');
    }
}
