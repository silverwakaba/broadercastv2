<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLinkTracker extends Model{
    protected $table = 'users_link_tracker';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'users_link_id',
        'base_link_id',
        // 'users_feed_id',
        'initialized',
        'identifier',
        'name',
        'avatar',
        'banner',
        'view',
        'subscriber',
        'joined',
        // 'streaming',
        // 'concurrent',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }

    public function belongsToUserLink(){
        return $this->belongsTo(UserLink::class, 'users_link_id');
    }

    public function belongsToActiveStream(){
        return $this->belongsTo(UserFeed::class, 'users_feed_id', 'id');
    }

    public function hasManyUserFeed(){
        return $this->hasMany(UserFeed::class, 'users_link_tracker_id', 'users_id');
    }
}
