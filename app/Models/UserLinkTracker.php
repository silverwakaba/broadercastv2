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
        'initialized',
        'identifier',
        'handler',
        'playlist',
        'trailer',
        'name',
        'avatar',
        'banner',
        'description',
        'content',
        'view',
        'subscriber',
        'joined',
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

    public function hasManyThroughUserAffiliation(){
        return $this->hasManyThrough(UserAffiliation::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasOneBiodataThroughUser(){
        return $this->hasOneThrough(UserBiodata::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyThroughUserContent(){
        return $this->hasManyThrough(UserContent::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyThroughUserGender(){
        return $this->hasManyThrough(UserGender::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyThroughUserLanguage(){
        return $this->hasManyThrough(UserLanguage::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyThroughUserRace(){
        return $this->hasManyThrough(UserRace::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function hasManyThroughUserFeed(){
        return $this->hasManyThrough(UserFeed::class, User::class, 'id', 'base_link_id', 'base_link_id', 'id');
    }

    // public function belongsToActiveStream(){
    //     return $this->belongsTo(UserFeed::class, 'users_feed_id', 'id');
    // }

    // public function hasManyUserFeed(){
    //     return $this->hasMany(UserFeed::class, 'users_link_tracker_id', 'users_id');
    // }
}
