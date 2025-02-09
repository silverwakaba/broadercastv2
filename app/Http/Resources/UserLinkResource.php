<?php

namespace App\Http\Resources;

use App\Http\Resources\BaseDecisionResource;
use App\Http\Resources\BaseLinkResource;

use App\Helpers\RedirectHelper;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserLinkResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'link'          => RedirectHelper::routeSign('go.out', 1, [
                'plain'         => (bool) Str::contains($this->link, 'https://'),
                'destination'   => (string) Str::chopStart($this->link, ['http://', 'https://']),
            ]),
            'link_plain'    => $this->link,
            'icon'          => $this->icon,
            'color'         => $this->color,
            'logo'          => $this->logo, //'https://cdn.simpleicons.org/' . ($logo) . '?viewbox=auto&bj=yes',
            'link_pivot'    => isset($this->pivot->link) ? $this->pivot->link : null,
            'decision'      => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
            'service'       => new BaseLinkResource($this->whenLoaded('belongsToBaseLink')),
        ];
    }
}
