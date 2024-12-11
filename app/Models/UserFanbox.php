<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFanbox extends Model{
    protected $table = 'users_fanbox';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_id',
        'identifier',
        'active',
        'public',
        'attachment',
        'title',
        'description',
    ];

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }
}
