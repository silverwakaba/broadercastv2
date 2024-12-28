<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

use Carbon\Carbon;

class UserFanboxResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'title'         => $this->title,
            'description'   => Str::markdown($this->description, ['html_input' => 'strip']),
            'active'        => $this->active == true ? '<i class="fas fa-circle text-success"></i>' : '<i class="fas fa-circle text-danger"></i>',
            'public'        => $this->public == true ? '<i class="fas fa-circle text-success"></i>' : '<i class="fas fa-circle text-danger"></i>',
            'created_at'    => Carbon::parse($this->created_at)->format('d M Y, g:i A'),
            'page'          => route('fanbox.answer', ['id' => $this->identifier]),
            'user'          => new UserResource($this->whenLoaded('belongsToUser')),
            'avatar'        => new UserAvatarResource($this->whenLoaded('hasOneThroughUserAvatar')),
        ];
    }
}
