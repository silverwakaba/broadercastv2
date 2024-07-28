<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserBiodata extends Model{
    // use SoftDeletes;
    
    protected $table = 'users_biodata';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'name',
        'nickname',
        'dob',
        'dod',
        'dor',
        'biography',
    ];

    public function hasOneUser(){
        return $this->hasOne(User::class, 'users_id');
    }
}
