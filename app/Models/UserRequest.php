<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRequest extends Model{
    protected $table = 'users_request';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'base_request_id',
        'users_request_id',
        'token',
    ];
}
