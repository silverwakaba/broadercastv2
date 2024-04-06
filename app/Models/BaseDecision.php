<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseDecision extends Model{
    protected $table = 'base_decision';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
