<?php

namespace App\Http\Resources;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Repositories\Base\ImageHandlerRepositories;

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

        if($anonymous == true){
            $avatar = ImageHandlerRepositories::avatarDefault();
        }
        else{
            $avatar = ImageHandlerRepositories::avatar($this->path);
        }

        return $avatar;
    }
}
