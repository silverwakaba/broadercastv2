<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFanboxSubmission extends Model{
    protected $table = 'users_fanbox_submission';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_fanbox_id',
        'users_id',
        'anonymous',
        'message',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToUserFanbox(){
        return $this->belongsTo(UserFanbox::class, 'users_fanbox_id');
    }
}
