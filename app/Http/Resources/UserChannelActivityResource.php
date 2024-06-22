<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Carbon\Carbon;
use Carbon\CarbonInterval;
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
            'id'                        => $this->id,
            'streaming'                 => $this->streaming,
            'concurrent'                => $this->concurrent,
            'identifier'                => $this->identifier,
            'title'                     => $this->title,
            'link'                      => $link,
            'thumbnail'                 => $thumbnail,
            'published'                 => $this->published ? Carbon::parse($this->published)->format('d M Y, g:i A') : null,
            'published_for_human'       => $this->published ? Carbon::parse($this->published)->diffForHumans() : null,
            'schedule'                  => $this->schedule ? Carbon::parse($this->schedule)->format('d M Y, g:i A') : null,
            'schedule_for_human'        => $this->schedule ? Carbon::parse($this->schedule)->diffForHumans() : null,
            'actual_start'              => $this->actual_start ? Carbon::parse($this->actual_start)->format('d M Y, g:i A') : null,
            'actual_start_for_human'    => $this->actual_start ? Carbon::parse($this->actual_start)->diffForHumans() : null,
            'actual_end'                => $this->actual_end ? Carbon::parse($this->actual_end)->format('d M Y, g:i A') : null,
            'actual_end_for_human'      => $this->actual_end ? Carbon::parse($this->actual_end)->diffForHumans() : null,
            'duration'                  => $this->streaming == false ? CarbonInterval::create($this->duration)->format('%H:%I:%S') : null,
            'timestamp'                 => $this->timestamp(),
            'timestamp_for_human'       => $this->timestampForHuman(),
            'user'                      => new UserResource($this->whenLoaded('belongsToUser')),
            'avatar'                    => new UserAvatarResource($this->whenLoaded('hasOneThroughUserAvatar')),
            'service'                   => new BaseLinkResource($this->whenLoaded('belongsToBaseLink')),
            'channel'                   => new UserChannelResource($this->whenLoaded('hasOneThroughUserLink')),
            'profile'                   => new UserChannelProfileResource($this->whenLoaded('belongsToUserLinkTracker')),
        ];
    }

    public function timestamp(){
        if(
            (($this->streaming == true) && ($this->schedule != null) && ($this->actual_start != null) && ($this->actual_end == null) && ($this->duration == "P0D"))
            ||
            (($this->streaming == true) && ($this->schedule == null) && ($this->actual_start != null) && ($this->actual_end == null) && ($this->duration == "P0D"))
            ||
            (($this->streaming == false) && ($this->schedule != null) && ($this->actual_start != null) && ($this->actual_end != null) && ($this->duration != "P0D"))
            ||
            (($this->streaming == false) && ($this->schedule == null) && ($this->actual_start != null) && ($this->actual_end != null) && ($this->duration != "P0D"))
        ){
            return Carbon::parse($this->actual_start)->format('d M Y, g:i A');
        }
        elseif(
            (($this->streaming == false) && ($this->schedule != null) && ($this->actual_start == null) && ($this->actual_end == null) && ($this->duration == "P0D"))
        ){
            return Carbon::parse($this->schedule)->format('d M Y, g:i A');
        }
        else{
            return Carbon::parse($this->published)->format('d M Y, g:i A');
        }
    }

    public function timestampForHuman(){
        if(
            (($this->streaming == true) && ($this->schedule != null) && ($this->actual_start != null) && ($this->actual_end == null) && ($this->duration == "P0D"))
            ||
            (($this->streaming == true) && ($this->schedule == null) && ($this->actual_start != null) && ($this->actual_end == null) && ($this->duration == "P0D"))
            ||
            (($this->streaming == false) && ($this->schedule != null) && ($this->actual_start != null) && ($this->actual_end != null) && ($this->duration != "P0D"))
            ||
            (($this->streaming == false) && ($this->schedule == null) && ($this->actual_start != null) && ($this->actual_end != null) && ($this->duration != "P0D"))
        ){
            return Carbon::parse($this->actual_start)->diffForHumans();
        }
        elseif(
            (($this->streaming == false) && ($this->schedule != null) && ($this->actual_start == null) && ($this->actual_end == null) && ($this->duration == "P0D"))
        ){
            return Carbon::parse($this->schedule)->diffForHumans();
        }
        else{
            return Carbon::parse($this->published)->diffForHumans();
        }
    }
}
