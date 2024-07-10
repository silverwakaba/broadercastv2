<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRace extends Model{    
    protected $table = 'users_race';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_race_id',
    ];
}
