<?php

namespace App\Models;

use App\Observers\UserObserver;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'base_status_id',
        'confirmed',
        'identifier',
        'email',
        'password',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts() : array{
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function belongsToBaseStatus(){
        return $this->belongsTo(BaseStatus::class, 'base_status_id');
    }

    public function hasOneUserAvatar(){
        return $this->hasOne(UserAvatar::class, 'users_id');
    }

    public function hasOneUserBiodata(){
        return $this->hasOne(UserBiodata::class, 'users_id');
    }

    public function hasOneUserRequest(){
        return $this->hasOne(UserRequest::class, 'user_id');
    }
}
