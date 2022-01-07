<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transaction';
    protected $guarded = [];

    public function user()
    {
        // [transaction] many-to-one user
        return $this->belongsTo(User::class, 'user_id');
    }

    public function keyboards()
    {
        // [transaction] many-to-many keyboard
        // [transaction] one-to-many transaction_keyboard many-to-one keyboard
        return $this->belongsToMany(Keyboard::class, 'transaction_keyboard', 'transaction_id', 'keyboard_id');
    }
}
