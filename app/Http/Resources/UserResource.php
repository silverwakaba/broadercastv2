<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseStatusResource;
use App\Http\Resources\UserAffiliationResource;
use App\Http\Resources\UserAvatarResource;
use App\Http\Resources\UserBiodataResource;
use App\Http\Resources\UserContentResource;
use App\Http\Resources\UserGenderResource;
use App\Http\Resources\UserLanguageResource;
use App\Http\Resources\UserLinkResource;
use App\Http\Resources\UserRaceResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class UserResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        $name = $this->name ? $this->name : strtoupper($this->identifier);

        return [
            'id'                => $this->id,
            'base_status_id'    => $this->base_status_id,
            'confirmed'         => $this->confirmed,
            'title_temp'        => $this->confirmed == true ? 'Verified Creator' : 'Unverified Creator',
            'identifier'        => $this->identifier,
            'page'              => route('creator.profile', $this->identifier),
            'rels'              => URL::temporarySignedRoute('creator.rels', now()->addHours(1), $this->identifier),
            'name'              => $name,
            'name_preview'      => Str::limit($name, 15, ' (...)'),
            'deleted_at'        => $this->deleted_at,
            'created_at'        => $this->created_at,
            'updated_at'        => $this->updated_at,
            'status'            => new BaseStatusResource($this->whenLoaded('belongsToBaseStatus')),
            'affiliation'       => UserAffiliationResource::collection($this->whenLoaded('belongsToManyUserAffiliation')),
            'avatar'            => new UserAvatarResource($this->whenLoaded('hasOneUserAvatar')),
            'biodata'           => new UserBiodataResource($this->whenLoaded('hasOneUserBiodata')),
            'content'           => UserContentResource::collection($this->whenLoaded('belongsToManyUserContent')),
            'gender'            => UserGenderResource::collection($this->whenLoaded('belongsToManyUserGender')),
            'language'          => UserLanguageResource::collection($this->whenLoaded('belongsToManyUserLanguage')),
            'link'              => UserLinkResource::collection($this->whenLoaded('belongsToManyUserLink')),
            'race'              => UserRaceResource::collection($this->whenLoaded('belongsToManyUserRace')),
            'followed'          => new UserFollowedResource($this->whenLoaded('belongsToUserRelationFollowed')),
        ];
    }
}
