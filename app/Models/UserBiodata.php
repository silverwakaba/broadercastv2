<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBiodata extends Model{
    protected $table = 'users_biodata';
    protected $primaryKey = 'users_biodata_id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'name',
        'nickname',
        'dob',
        'dod',
        'biography',
    ];

    public function hasOneUser(){
        return $this->hasOne(User::class, 'users_id');
    }
}
