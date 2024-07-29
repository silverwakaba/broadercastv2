<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Http\Resources\BaseDecisionResource;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseLinkResource extends JsonResource{
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
            $logo = 'googlechrome';
        }

        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'icon'      => $this->icon,
            'color'     => $this->color,
            'logo'      => 'https://cdn.simpleicons.org/' . ($logo) . '?viewbox=auto',
            'checking'  => $this->checking,
            'user'      => new UserResource($this->whenLoaded('hasOneUser')),
            'decision'  => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
        ];
    }
}
