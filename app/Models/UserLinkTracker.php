<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLinkTracker extends Model{
    protected $table = 'users_link_tracker';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'users_link_id',
        'base_link_id',
        'identifier',
        'name',
        'avatar',
        'view',
        'subscriber',
        'joined',
        'streaming',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }
}
