<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\UserResource;
use App\Http\Resources\BaseDecisionResource;

class BaseLinkResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'icon'      => $this->icon,
            'color'     => $this->color,
            'logo'      => 'https://cdn.simpleicons.org/' . ($this->icon ? Str::lower($this->icon) : Str::lower($this->name)) . '/' . ($this->color ? Str::lower($this->color) : '000000'),
            'checking'  => $this->checking,
            'user'      => new UserResource($this->whenLoaded('hasOneUser')),
            'decision'  => new BaseDecisionResource($this->whenLoaded('belongsToBaseDecision')),
        ];
    }
}
