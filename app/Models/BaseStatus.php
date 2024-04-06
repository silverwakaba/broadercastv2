<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseStatus extends Model{
    protected $table = 'base_status';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
