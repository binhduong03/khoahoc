<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courses extends Model
{
    protected $table = 'tb_course';
    protected $primaryKey = 'course_id';

    protected $fillable = [
        'course_id',
        'user_id',
        'name',
        'image',
        'description',
        'price',
        'duration',
        'status',
        'created_at',
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo(Users::class, 'user_id', 'user_id');
    }

    public function combocourse(){
        return $this->hasMany(ComboCourse::class, 'course_id', 'course_id');
    }

    public function chapters(){
        return $this->hasMany(Chapters::class, 'course_id', 'course_id');
    }
}
