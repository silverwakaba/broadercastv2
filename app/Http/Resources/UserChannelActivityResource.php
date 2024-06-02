<?php

namespace App\Http\Resources;

use App\Models\BaseLink;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            $link = 'https://www.youtube.com/watch?v=' . $this->identifier;
            $thumbnail = 'https://i.ytimg.com/vi/' . $this->identifier . '/maxresdefault_live.jpg';
        }
        else{
            $link = null;
        }

        return [
            'id'            => $this->id,
            'identifier'    => $this->identifier,
            'title'         => $this->title,
            'link'          => $link,
            'thumbnail'     => $thumbnail,
        ];
    }
}
