<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFeed extends Model{
    protected $table = 'users_feed';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_link_id',
        'users_link_tracker_id',
        'identifier',
        'title',
        'published',
        'updated',
    ];

    // public function belongsToUser(){
    //     return $this->belongsTo(User::class, 'users_id');
    // }

    // public function hasOneThroughUserAvatar(){
    //     return $this->hasOneThrough(UserAvatar::class, User::class, 'users_id', 'users_id', 'users_id', 'users_id');
    // }

    // public function hasOneThroughUserBiodata(){
    //     return $this->hasOneThrough(UserBiodata::class, User::class, 'users_id', 'users_id', 'users_id', 'users_id');
    // }

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }

    public function belongsToUserLinkTracker(){
        return $this->belongsTo(UserLinkTracker::class, 'users_link_tracker_id');
    }
}
