<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseType extends Model{
    protected $table = 'base_type';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'base_decision_id',
        'name',
    ];

    public function belongsToBaseDecision(){
        return $this->belongsTo(BaseDecision::class, 'base_decision_id');
    }
}
