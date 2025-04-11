<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'cart_id',
        'amount',
        'payment_method',
        'payment_status',
        'payment_date'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id'); 
    }
}
