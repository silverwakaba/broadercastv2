<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserContent extends Model{    
    protected $table = 'users_content';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_content_id',
    ];
}
