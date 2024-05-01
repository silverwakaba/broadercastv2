<?php

namespace App\Models;

use App\Observers\BaseRaceObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy([BaseRaceObserver::class])]
class BaseRace extends Model{
    use SoftDeletes;

    protected $table = 'base_race';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_decision_id',
        'name',
    ];

    public function belongsToBaseDecision(){
        return $this->belongsTo(BaseDecision::class, 'base_decision_id');
    }

    public function hasOneUser(){
        return $this->hasOne(User::class, 'id', 'users_id');
    }

    public function hasOneUserBiodata(){
        return $this->hasOne(UserBiodata::class, 'id', 'users_id');
    }

    // public function hasOneThroughUser(){
    //     return $this->hasOneThrough(User::class, UserBiodata::class, 'users_id', 'id', 'users_id', 'users_id');
    // }
}
