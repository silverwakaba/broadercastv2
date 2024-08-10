<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAffiliation extends Model{    
    protected $table = 'users_affiliation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_affiliation_id',
    ];
}
