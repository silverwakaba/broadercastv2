<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFanboxAttachment extends Model{
    protected $table = 'users_fanbox_attachment';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'users_fanbox_submission_id',
        'users_id',
        'base_mime_id',
        'size',
    ];

    public function belongsToBasseMime(){
        return $this->belongsTo(BasseMime::class, 'base_mime_id');
    }

    public function belongsToUser(){
        return $this->belongsTo(User::class, 'users_id');
    }

    public function belongsToUserFanboxSubmission(){
        return $this->belongsTo(UserFanboxSubmission::class, 'users_fanbox_submission_id');
    }
}
