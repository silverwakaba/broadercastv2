<?php

namespace App\Http\Resources;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAvatarFanboxResource extends JsonResource{
    protected $anonymous;

    public function __construct($resource, $anonymous){
        parent::__construct($resource);
        $this->anonymous = $anonymous;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'path' => $this->avatar(),
        ];
    }

    public function avatar(){
        $anonymous = $this->anonymous;

        $avatarNo = Factory::create()->numberBetween(1, 5);

        if($anonymous == true){
            $avatar = config('app.cdn_static_url') . "/system/internal/image/avatar/avatar-" . $avatarNo . ".png";
        }
        else{
            $avatar = $this->path ? config('app.cdn_public_url') . "/project/vtual/system/avatar/$this->path" : config('app.cdn_static_url') . "/system/internal/image/avatar/avatar-" . $avatarNo . ".png";
        }

        return $avatar;
    }
}
