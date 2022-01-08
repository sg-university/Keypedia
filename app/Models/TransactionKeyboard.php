<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionKeyboard extends Pivot
{
    use HasFactory;

    protected $table = 'transaction_keyboard';
    protected $guarded = [];
    public $incrementing = true;

    public function transaction()
    {
        // [transaction_keyboard] one-to-many transaction many-to-one transaction_keyboard
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function keyboard()
    {
        // [transaction_keyboard] one-to-many keyboard many-to-one transaction_keyboard
        return $this->belongsTo(Keyboard::class, 'keyboard_id');
    }
}
