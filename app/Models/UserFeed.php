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
        'base_status_id',
        'base_feed_type_id',
        'concurrent',
        'identifier',
        'title',
        'published',
        'schedule',
        'actual_start',
        'actual_end',
        'duration',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function hasOneThroughUserAvatar(){
        return $this->hasOneThrough(UserAvatar::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    // public function hasOneThroughUserBiodata(){
    //     return $this->hasOneThrough(UserBiodata::class, User::class, 'users_id', 'users_id', 'users_id', 'users_id');
    // }

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }

    public function belongsToUserLinkTracker(){
        return $this->belongsTo(UserLinkTracker::class, 'users_link_tracker_id');
    }

    public function hasOneThroughUserLink(){
        return $this->hasOneThrough(UserLink::class, UserLinkTracker::class, 'id', 'id', 'users_link_tracker_id', 'users_link_id');
    }

    public function belongsToUserRelationFollowed(){
        return $this->belongsTo(UserRelation::class, 'users_id', 'users_followed_id')->where([
            ['users_follower_id', '=', auth()->user()->id],
        ]);
    }
}
