<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFanboxSubmission extends Model{
    protected $table = 'users_fanbox_submission';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_fanbox_id',
        'users_id',
        'anonymous',
        'message',
    ];

    public function belongsToUser(){ // The one who answer the question
        return $this->belongsTo(User::class, 'users_id');
    }

    public function hasOneThroughUser(){  // The one who make the question
        return $this->hasOneThrough(User::class, UserFanbox::class, 'id', 'id', 'users_fanbox_id', 'users_id',);
    }

    public function hasOneThroughUserAvatar(){
        return $this->hasOneThrough(UserAvatar::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function belongsToUserFanbox(){
        return $this->belongsTo(UserFanbox::class, 'users_fanbox_id');
    }
}
