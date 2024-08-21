<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserChannelProfileResource extends JsonResource{
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
        }
        elseif($data->name == 'Twitch'){
            $avatar = $this->avatar ? Str::of(config('app.cdn_cache_twitch') . '/')->append($this->avatar) : $null;
        }
        else{
            $avatar = $null;
        }

        return [
            'id'         => $this->id,
            'identifier' => $this->identifier,
            'name'       => $this->name,
            'avatar'     => $avatar,
        ];
    }
}