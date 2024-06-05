<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseDecisionResource;
use App\Http\Resources\BaseLinkResource;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserLinkResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        if(($this->icon == null || $this->icon !== null) && ($this->icon !== '404')){
            $logo = $this->icon == null ? Str::lower($this->name) : Str::lower($this->icon);
        }
        elseif($this->icon == '404'){
            $logo = 'internetexplorer';
        }

        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'link'          => $this->link,
            'icon'          => $this->icon,
            'color'         => $this->color,
            'logo'          => 'https://cdn.simpleicons.org/' . ($logo),
            'link_pivot'    => isset($this->pivot->link) ? $this->pivot->link : null,
            'decision'      => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
            'service'       => new BaseLinkResource($this->whenLoaded('belongsToBaseLink')),
        ];
    }
}
