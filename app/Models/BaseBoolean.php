<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseBoolean extends Model{
    protected $table = 'base_boolean';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'value',
    ];
}
