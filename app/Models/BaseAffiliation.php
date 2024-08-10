<?php

namespace App\Models;

// use App\Observers\BaseRaceObserver;
// use Illuminate\Database\Eloquent\Attributes\ObservedBy;
// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

// #[ObservedBy([BaseRaceObserver::class])]
class BaseAffiliation extends Model{
    // use SoftDeletes;

    protected $table = 'base_affiliation';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_decision_id',
        'identifier',
        'name',
        'about',
    ];

    public function belongsToBaseDecision(){
        return $this->belongsTo(BaseDecision::class, 'base_decision_id');
    }

    public function hasOneUser(){
        return $this->hasOne(User::class, 'id', 'users_id');
    }
}
