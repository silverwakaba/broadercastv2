<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAvatarResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'users_id'  => $this->users_id,
            'path'      => $this->path ? "https://public-cdn.broadercast.net/system/avatar/$this->path" : "https://public-cdn.broadercast.net/system/avatar/default.webp",
        ];
    }
}
