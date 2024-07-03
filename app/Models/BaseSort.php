<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BaseSort extends Model{
    // use SoftDeletes;

    protected $table = 'base_sort';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];
}
