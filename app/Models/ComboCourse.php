<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComboCourse extends Model
{
    protected $table = 'tb_combo_course';
    protected $primaryKey = 'combo_course_id';
    public $timestamps = false;

    protected $fillable = [
        'combo_id',
        'course_id',
        'sequence'
    ];

    public function combo(){
        return $this->belongsTo(Combos::class, 'combo_id', 'combo_id');
    }

    public function course(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }
}
