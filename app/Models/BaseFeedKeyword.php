<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseFeedKeyword extends Model{
    protected $table = 'base_feed_keyword';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'base_feed_type_id',
        'name',
        'keyword',
    ];
}
