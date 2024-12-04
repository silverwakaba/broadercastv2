<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseProxyHost extends Model{
    protected $table = 'base_proxy_host';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'base_proxy_type_id',
        'online',
        'host',
    ];

    public function belongsToBaseProxyType(){
        return $this->belongsTo(BaseProxyType::class, 'base_proxy_type_id', 'id');
    }
}
