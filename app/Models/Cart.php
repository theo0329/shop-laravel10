<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function cartItems()
    {
        return $this->hasmany('App\Models\CartItem');
    }
}
