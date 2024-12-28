<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseProxyHostResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'id'        => $this->id,
            'type'      => new BaseProxyTypeResource($this->whenLoaded('belongsToBaseProxyType')),
            'host'      => $this->host,
            'online'    => $this->online == true ? '<i class="fas fa-circle text-success"></i>' : '<i class="fas fa-circle text-danger"></i>',
        ];
    }
}
