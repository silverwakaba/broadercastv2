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
            ['id', '=', $this->base_link_id]
        ])->first();

        $null = env('CDN_URL_PUBLIC') . "/system/misc/banner.jpg";

        if($data->name == 'YouTube'){
            $banner = $this->banner ? Str::of($this->banner)->append('=w1080-fcrop64=1,00005a57ffffa5a8-k-c0xffffffff-no-nd-rj') : $null;
        }
        else{
            $banner = null;
        }

        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'name'          => $this->name,
            'name_preview'  => Str::limit($this->name, 15, ' (...)'),
            'avatar'        => $this->avatar,
            'banner'        => $banner,
            'view'          => $this->view,
            'subscriber'    => $this->subscriber,
            'streaming'     => $this->streaming,
            'concurrent'    => $this->concurrent,
            'link'          => new UserLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'       => new UserChannelResource($this->whenLoaded('belongsToUserLink')),
            'activity'      => new UserChannelActivityResource($this->whenLoaded('belongsToActiveStream')),
        ];
    }
}
