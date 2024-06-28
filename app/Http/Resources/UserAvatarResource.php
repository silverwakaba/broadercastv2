<?php

namespace App\Http\Resources;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAvatarResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'users_id'  => $this->users_id,
            'path'      => $this->path ? config('app.cdn_public_url') . "/project/broadercast/system/avatar/$this->path" : config('app.cdn_public_url') . "/system/image/avatar/avatar-" . $this->randomAvatar() . ".png",
        ];
    }
    
    public function randomAvatar(){
        $faker = Factory::create();

        return $faker->numberBetween(1, 5);
    }
}
