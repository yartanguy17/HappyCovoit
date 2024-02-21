<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Notification extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'contenu' => $this->contenu,
            'titre' => $this->titre,
            'user' => $this->user->email,
            'avatar' => $this->avatar,
            'created_at' => formatDate2($this->created_at)
        ];
    }
}
