<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chapters extends Model
{
    protected $table = 'tb_chapters';
    protected $primaryKey = 'chapter_id';

    protected $fillable = [
        'title',
        'content',
        'course_id',
    ];

    public function course(){
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }

    public function lectures(){
        return $this->hasMany(Lectures::class, 'chapter_id', 'chapter_id'); 
    }

    
}
