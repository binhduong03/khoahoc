<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercises extends Model
{
    protected $table = 'tb_exercises';
    protected $primaryKey = 'exercises_id';

    protected $fillable = [
        'lecture_id',
        'title',
        'description',
        'file_path',
        'due_date',
        'status'
    ];

    
    public function lecture(){
        $this->belongsTo(Lectures::class, 'lecture_id', 'lecture_id');
    }
}
