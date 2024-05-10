<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseDecisionResource;
use App\Http\Resources\BaseLinkResource;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLinkResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'decision'  => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
            'service'   => new BaseLinkResource($this->whenLoaded('belongsToBaseLink')),
            'link'      => $this->link,
        ];
    }
}
