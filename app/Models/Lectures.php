<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lectures extends Model
{
    protected $table = 'tb_lectures'; 
    protected $primaryKey = 'lecture_id'; 

    protected $fillable = [
        'chapter_id',
        'title',
        'content',
        'media_type',
        'media_url',
        'order',
        'status'
    ];

    public function chapter()
    {
        return $this->belongsTo(Chapters::class, 'chapter_id'); 
    }

    public function exercise()
    {
        return $this->hasMany(Exercises::class, 'lecture_id', 'lecture_id'); 
    }


}
