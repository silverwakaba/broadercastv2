<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

use Carbon\Carbon;

class UserFanboxSubmissionResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'anonymous'     => $this->anonymous,
            'message'       => $this->message,
            'message_md'    => Str::markdown($this->message, ['html_input' => 'strip']),
            'created_at'    => Carbon::parse($this->created_at)->format('d M Y, g:i A'),
            'userWhoAsked'  => new UserResource($this->whenLoaded('hasOneThroughUser')),
            'userWhoAnswer' => new UserFanboxAnswerResource($this->whenLoaded('belongsToUser'), $this->anonymous),
            'avatar'        => new UserAvatarFanboxResource($this->whenLoaded('hasOneThroughUserAvatar'), $this->anonymous),
            'fanbox'        => new UserFanboxResource($this->whenLoaded('belongsToUserFanbox')),
        ];
    }
}
