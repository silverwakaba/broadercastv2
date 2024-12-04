<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseProxyType extends Model{
    protected $table = 'base_proxy_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
