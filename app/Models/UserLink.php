<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLink extends Model{
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
}
