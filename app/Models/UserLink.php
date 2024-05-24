<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserLink extends Model{
    use SoftDeletes;
    
    protected $table = 'users_link';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_link_id',
        'base_decision_id',
        'link',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToBaseDecision(){
        return $this->belongsTo(BaseDecision::class, 'base_decision_id');
    }

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }

    public function hasOneUserLinkTracker(){
        return $this->hasOne(UserLinkTracker::class, 'users_link_id');
    }

    public function belongsToManyUserLinkTracker(){
        return $this->belongsToMany(BaseLink::class, 'users_link_tracker', 'users_id', 'base_link_id');
    }
}
