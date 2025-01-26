<?php

namespace App\Models;

use App\Observers\UserObserver;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// Extra lib for sitemap
use Spatie\Sitemap\Contracts\Sitemapable;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

#[ObservedBy([UserObserver::class])]
class User extends Authenticatable implements Sitemapable{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'base_status_id',
        '2fa',
        'confirmed',
        'sitemaped',
        'identifier',
        'name',
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

    public function toSitemapTag() : Url | string | array{
        $sitemapable = Url::create(route('creator.profile', $this->identifier))
            ->setLastModificationDate(Carbon::create($this->updated_at))
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY)
            ->setPriority(0.5);
        
        return $sitemapable;
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

    public function belongsToManyUserAffiliation(){
        return $this->belongsToMany(BaseAffiliation::class, 'users_affiliation', 'users_id', 'base_affiliation_id');
    }

    public function belongsToManyUserContent(){
        return $this->belongsToMany(BaseContent::class, 'users_content', 'users_id', 'base_content_id');
    }

    public function belongsToManyUserGender(){
        return $this->belongsToMany(BaseGender::class, 'users_gender', 'users_id', 'base_gender_id');
    }

    public function belongsToManyUserLanguage(){
        return $this->belongsToMany(BaseLanguage::class, 'users_language', 'users_id', 'base_language_id');
    }

    public function belongsToManyUserLink(){
        return $this->belongsToMany(BaseLink::class, 'users_link', 'users_id', 'base_link_id')->withPivot('link');
    }
    
    // Is now used exclusively as sitemapable component
    public function belongsToManyUserLinkTrackerAsSitemapableQuery(){
        return $this->belongsToMany(BaseLink::class, 'users_link_tracker', 'users_id', 'base_link_id');//->withPivot('id', 'identifier', 'name', 'avatar', 'view', 'subscriber', 'joined');
    }

    public function belongsToManyUserLinkDecision(){
        return $this->belongsToMany(BaseDecision::class, 'users_link', 'users_id', 'base_decision_id');
    }

    public function belongsToManyUserRace(){
        return $this->belongsToMany(BaseRace::class, 'users_race', 'users_id', 'base_race_id');
    }

    public function hasOneUserRequest(){
        return $this->hasOne(UserRequest::class, 'users_id');
    }

    // Is now used exclusively as sitemapable component
    public function belongsToManyUserFeedAsSitemapableQuery(){
        return $this->belongsToMany(BaseLink::class, 'users_feed', 'users_id', 'base_link_id');//->withPivot('identifier', 'title', 'published');
    }

    public function belongsToUserRelationFollowed(){ // Can be used through "has('belongsToUserRelationFollowed')" method
        $uid = isset(auth()->user()->id) ? auth()->user()->id : 0;

        return $this->belongsTo(UserRelation::class, 'id', 'users_followed_id')->where([
            ['users_follower_id', '=', $uid],
        ]);
    }
}
