<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserChannelActivityResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        $data = BaseLink::where([
            ['id', '=', $this->base_link_id]
        ])->first();

        if($data->name == 'YouTube'){
            $link = Str::replace('REPLACETHISPLACEHOLDER', $this->identifier, $data->url_content);
            $thumbnail = Str::replace('REPLACETHISPLACEHOLDER', $this->identifier, $data->url_thumbnail);
        }
        else{
            $link = null;
        }

        return [
            'id'                    => $this->id,
            'identifier'            => $this->identifier,
            'title'                 => $this->title,
            'link'                  => $link,
            'thumbnail'             => $thumbnail,
            'published'             => $this->published ? Carbon::parse($this->published)->format('d M Y, g:i A') : null,
            'published_for_human'   => $this->published ? Carbon::parse($this->published)->diffForHumans() : null,
            'user'                  => new UserResource($this->whenLoaded('belongsToUser')),
            'avatar'                => new UserAvatarResource($this->whenLoaded('hasOneThroughUserAvatar')),
            'service'               => new BaseLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'               => new UserChannelResource($this->whenLoaded('hasOneThroughUserLink')),
            'profile'               => new UserChannelProfileResource($this->whenLoaded('belongsToUserLinkTracker')),
        ];
    }
}
