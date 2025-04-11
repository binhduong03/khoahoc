<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExerciseSubmission extends Model
{
    protected $table = 'tb_exercise_submission';
    protected $primaryKey = 'submission_id';

    protected $fillable = [
        'user_id', 
        'exercises_id', 
        'file_path', 
        'score', 
        'feedback', 
        'submission_date', 
        'status'
    ];
}
