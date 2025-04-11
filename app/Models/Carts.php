<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $table = 'tb_carts';
    protected $primaryKey = 'cart_id';

    protected $fillable = [
        'user_id',
        'course_id',
        'combo_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function combo()
    {
        return $this->belongsTo(Combos::class, 'combo_id', 'combo_id');
    }
}
