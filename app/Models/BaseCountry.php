<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BaseCountry extends Model{
    use SoftDeletes;

    protected $table = 'base_country';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id2',
        'id3',
        'name',
    ];
}
