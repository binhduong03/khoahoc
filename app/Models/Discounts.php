<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    protected $table = 'tb_discounts';
    protected $primaryKey = 'discount_id';

    protected $fillable = [
        'combo_id',
        'course_id',
        'title',
        'discount_percentage',
        'start_date',
        'end_date',
        'user_type',
        
        'status'
    ];
}
