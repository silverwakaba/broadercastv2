<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'id'                => $this->id,
            'users_id'          => $this->users_id,
            'nickname'          => $this->nickname ? explode(PHP_EOL, $this->nickname) : null,
            'nickname_preview'  => Str::limit($this->nickname, 15, ' (...)'),
            'dob'               => $this->dob ? Carbon::parse($this->dob)->format('d M') : null,
            'dobDiff'           => $this->dob ? Carbon::parse($this->dob)->diffForHumans() : null,
            'dod'               => $this->dod ? Carbon::parse($this->dod)->format('d M Y') : null,
            'dodDiff'           => $this->dod ? Carbon::parse($this->dod)->diffForHumans() : null,
            'dor'               => $this->dor ? Carbon::parse($this->dor)->format('d M Y') : null,
            'dorDiff'           => $this->dor ? Carbon::parse($this->dor)->diffForHumans() : null,
            'biography'         => $this->biography ? $markdownBioStripped : $this->biography,
        ];
    }
}
