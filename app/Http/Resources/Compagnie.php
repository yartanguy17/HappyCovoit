<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Compagnie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "denomination" => $this->denomination,
            "abonnes" => $this->abonnes,
            "status" => $this->user->status,
            "avatar" => $this->user->avatar
        ];
    }
}
