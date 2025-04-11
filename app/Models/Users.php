<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'tb_user';
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'fullname',
        'username',
        'password',
        'avatar',
        'phone',
        'email',
        'gender',
        'date_of_birt',
        'address',
        'role',
        'status',
    ];

    public function courses() {
        return $this->hasMany(Courses::class, 'user_id', 'user_id');
    }

    public function carts(){
        return $this->hasMany(Carts::class, 'user_id', 'user_id');
    }

    
}
