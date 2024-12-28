<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserFanboxAnswerResource extends JsonResource{
    protected $anonymous;

    public function __construct($resource, $anonymous){
        parent::__construct($resource);
        $this->anonymous = $anonymous;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request) : array{
        return [
            'name'  => $this->displayName(),
            'page'  => route('creator.profile', $this->displayIdentifier()),
        ];
    }

    public function displayName(){
        $anonymous = $this->anonymous;

        if($anonymous == true){
            $name = "Anonymous";
        }
        else{
            $name = $this->name ? $this->name : strtoupper($this->identifier);
        }

        return $name;
    }

    public function displayIdentifier(){
        $anonymous = $this->anonymous;

        if($anonymous == true){
            $identifier = "robot404";
        }
        else{
            $identifier = $this->identifier;
        }

        return $identifier;
    }
}
