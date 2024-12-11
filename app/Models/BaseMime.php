<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseMime extends Model{
    protected $table = 'base_mime';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
