<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseAPI extends Model{
    protected $table = 'base_api';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'base_link_id',
        'client_id',
        'client_key',
        'client_secret',
        'bearer',
    ];

    public function belongsToBaseLink(){
        return $this->belongsTo(BaseLink::class, 'base_link_id');
    }
}
