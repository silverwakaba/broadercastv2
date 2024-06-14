<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseFeedType extends Model{
    protected $table = 'base_feed_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
}
