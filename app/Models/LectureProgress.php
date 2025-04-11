<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureProgress extends Model
{
    protected $table = 'lecture_progress'; 
    protected $primaryKey = 'lecture_progress_id'; 

    protected $fillable = [
        'user_id',
        'lecture_id',
        'progress',
        'status'
    ];
    
    public function user()
    {
        return $this->belongsTo(Users::class, 'user_id'); 
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class, 'lecture_id');
    }
}
