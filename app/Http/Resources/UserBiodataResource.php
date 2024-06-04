<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class UserBiodataResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        $markdownBio = Str::of($this->biography)->markdown([
            'html_input'            => 'strip',
            'allow_unsafe_links'    => false,
        ]);

        $markdownBioStripped = strip_tags($markdownBio, ['p', 'strong', 'em', 'ol', 'ul', 'li', 'code', 'blockquote']);

        return [
            'id'        => $this->id,
            'users_id'  => $this->users_id,
            'nickname'  => $this->nickname,
            'dob'       => $this->dob,
            'dod'       => $this->dod,
            'biography' => $this->biography ? $markdownBioStripped : $this->biography,
        ];
    }
}
