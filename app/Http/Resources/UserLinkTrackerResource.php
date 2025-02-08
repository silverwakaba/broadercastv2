<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

use App\Helpers\RedirectHelper;
use App\Repositories\Base\ImageHandlerRepositories;

class UserLinkTrackerResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'name'          => $this->name,
            'name_preview'  => Str::limit($this->name, 15, ' (...)'),
            'avatar'        => ImageHandlerRepositories::channelAvatar($this->base_link_id, $this->avatar),
            'banner'        => ImageHandlerRepositories::channelBanner($this->base_link_id, $this->banner),
            'view'          => $this->view,
            'content'       => $this->content,
            'subscriber'    => $this->subscriber,
            'profile'       => new UserResource($this->whenLoaded('belongsToUser')),
            'link'          => new UserLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'       => new UserChannelResource($this->whenLoaded('belongsToUserLink')),
            'visit'         => $this->transformLink($this->base_link_id, $this->identifier, $this->handler),
        ];
    }

    public function transformLink($baseLink, $identifier, $handler){
        $url = null;

        if(($baseLink == 1)){
            $url = "https://www.twitch.tv/$handler";
        }
        elseif(($baseLink == 2)){
            $url = "https://www.youtube.com/channel/$identifier";
        }

        return RedirectHelper::routeSign('go.out', 1, [
            'plain'         => false,
            'destination'   => (string) Str::chopStart($url, ['http://', 'https://']),
        ]);
    }
}
