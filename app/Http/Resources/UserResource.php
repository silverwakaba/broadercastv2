<?php

namespace App\Http\Resources;

use App\Http\Resources\UserAvatarResource;
use App\Http\Resources\UserBiodataResource;
use App\Http\Resources\UserContentResource;
use App\Http\Resources\UserGenderResource;
use App\Http\Resources\UserLanguageResource;
// use App\Http\Resources\UserLinkResource;
use App\Http\Resources\UserRaceResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'name'          => $this->name ? $this->name : '-',
            'email'         => $this->email,
            'deleted_at'    => $this->deleted_at,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'avatar'        => new UserAvatarResource($this->whenLoaded('hasOneUserAvatar')),
            'biodata'       => new UserBiodataResource($this->whenLoaded('hasOneUserBiodata')),
            'content'       => UserContentResource::collection($this->whenLoaded('belongsToManyUserContent')),
            'gender'        => UserGenderResource::collection($this->whenLoaded('belongsToManyUserGender')),
            'language'      => UserLanguageResource::collection($this->whenLoaded('belongsToManyUserLanguage')),
            // 'link'          => UserLinkResource::collection($this->whenLoaded('belongsToManyUserLink')), // Ganti Resourcenya
            'race'          => UserRaceResource::collection($this->whenLoaded('belongsToManyUserRace')),
        ];
    }
}
