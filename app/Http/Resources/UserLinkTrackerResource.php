<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'name_preview'  => Str::limit($this->name, 15, ' (...)'),
            'avatar'        => $this->avatar,
            'banner'        => Str::of($this->banner)->append('=w1080-fcrop64=1,00005a57ffffa5a8-k-c0xffffffff-no-nd-rj'),
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
