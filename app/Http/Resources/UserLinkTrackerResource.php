<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserLinkTrackerResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        $data = BaseLink::where([
            ['id', '=', $this->base_link_id],
        ])->select('name')->first();

        $null = config('app.cdn_static_url') . "/system/internal/image/misc/placeholder/banner.jpg";

        if($data->name == 'YouTube'){
            $avatar = $this->avatar ? Str::of(config('app.cdn_cache_youtube_profile') . '/')->append($this->avatar) : $null;
            $banner = $this->banner ? Str::of(config('app.cdn_cache_youtube_profile') . '/')->append(Str::of($this->banner)->append('=w1080-fcrop64=1,00005a57ffffa5a8-k-c0xffffffff-no-nd-rj')) : $null;
        }
        else{
            $avatar = $null;
            $banner = $null;
        }

        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'name'          => $this->name,
            'name_preview'  => Str::limit($this->name, 15, ' (...)'),
            'avatar'        => $avatar,
            'banner'        => $banner,
            'view'          => $this->view,
            'content'       => $this->content,
            'subscriber'    => $this->subscriber,
            'profile'       => new UserResource($this->whenLoaded('belongsToUser')),
            'link'          => new UserLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'       => new UserChannelResource($this->whenLoaded('belongsToUserLink')),
        ];
    }
}
