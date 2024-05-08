<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserAvatar extends Model{
    // use SoftDeletes;

    protected $table = 'users_avatar';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'path',
    ];

    public function belongsToUserModel(){
        return $this->belongsTo(User::class, 'users_id');
    }
}
