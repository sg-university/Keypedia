<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartKeyboard extends Pivot
{
    use HasFactory;

    protected $table = 'cart_keyboard';
    protected $guarded = [];
    public $incrementing = true;

    public function cart()
    {
        // [cart_keyboard] one-to-many cart many-to-one cart_keyboard
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function keyboard()
    {
        // [cart_keyboard] one-to-many keyboard many-to-one cart_keyboard
        return $this->belongsTo(Keyboard::class, 'keyboard_id');
    }
}
