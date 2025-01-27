<?php

namespace App\Http\Resources;

use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Repositories\Base\ImageHandlerRepositories;

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
            'path'      => ImageHandlerRepositories::avatar($this->path),
        ];
    }
}
