<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model{    
    protected $table = 'users_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_type_id',
    ];
}
