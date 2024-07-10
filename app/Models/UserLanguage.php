<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model{    
    protected $table = 'users_language';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'users_id',
        'base_language_id',
    ];
}
