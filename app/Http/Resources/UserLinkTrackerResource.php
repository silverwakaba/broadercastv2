<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLinkTrackerResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'name'          => $this->name,
            'avatar'        => $this->avatar,
            'view'          => $this->view,
            'subscriber'    => $this->subscriber,
            'streaming'     => $this->streaming,
            'concurrent'    => $this->concurrent,
            'link'          => new UserLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'       => new UserChannelResource($this->whenLoaded('belongsToUserLink')),
            'activity'      => new UserChannelActivityResource($this->whenLoaded('belongsToActiveStream')),
        ];
    }
}
