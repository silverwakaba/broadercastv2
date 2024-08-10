<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseAffiliationResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'avatar'    => new UserAvatarResource($this->whenLoaded('hasOneUserAvatar')),
            'user'      => new UserResource($this->whenLoaded('hasOneUser')),
            'decision'  => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
        ];
    }
}
