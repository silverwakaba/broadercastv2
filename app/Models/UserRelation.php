<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRelation extends Model{    
    protected $table = 'users_relation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_follower_id',
        'users_followed_id',
    ];
}
