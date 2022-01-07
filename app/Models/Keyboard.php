<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keyboard extends Model
{
    use HasFactory;
    protected $table = 'keyboard';
    protected $guarded = [];

    public function category()
    {
        // [keyboard] many-to-one category
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function carts()
    {
        // [keyboard] many-to-many cart
        // [keyboard] one-to-many cart_keyboard many-to-one cart
        return $this->belongsToMany(Cart::class, 'cart_keyboard', 'keyboard_id', 'cart_id');
    }

    public function transactions()
    {
        // [keyboard] many-to-many transaction
        // [keyboard] one-to-many transaction_keyboard many-to-one keyboard
        return $this->belongsToMany(Keyboard::class, 'transaction_keyboard', 'keyboard_id', 'transaction_id');
    }
}
