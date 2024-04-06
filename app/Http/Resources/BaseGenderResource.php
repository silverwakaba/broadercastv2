<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserResource;
use App\Http\Resources\BaseDecisionResource;

class BaseGenderResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'user'      => new UserResource($this->whenLoaded('hasOneUser')),
            'decision'  => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
        ];
    }
}
