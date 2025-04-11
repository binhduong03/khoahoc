<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Combos extends Model
{
    protected $table = 'tb_combos';
    protected $primaryKey = 'combo_id';

    protected $fillable = [
        'name', 
        'description', 
        'price', 
        'image',
        'status'
    ];

    public function comboCourses(){
        return $this->hasMany(ComboCourse::class, 'combo_id');
    }
}
