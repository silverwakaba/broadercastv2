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
            'path'      => $this->path ? env('ASSET_URL') . "/system/avatar/$this->path" : env('ASSET_URL') . "/system/avatar/default.webp",
        ];
    }
}
