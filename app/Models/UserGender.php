<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGender extends Model{    
    protected $table = 'users_gender';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_gender_id',
    ];
}
