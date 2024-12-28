<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFanbox extends Model{
    protected $table = 'users_fanbox';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'identifier',
        'active',
        'public',
        'attachment',
        'title',
        'description',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToUserFanboxSubmission(){
        return $this->belongsTo(UserFanboxSubmission::class, 'id', 'users_fanbox_id');
    }

    public function hasOneThroughUserAvatar(){
        return $this->hasOneThrough(UserAvatar::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyUserFanboxSubmission(){
        return $this->hasMany(UserFanboxSubmission::class, 'users_fanbox_id');
    }
}
