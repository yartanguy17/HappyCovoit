<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\DestinationCompagnie as DestinationCompagnieResource;

class LigneDestination extends JsonResource
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
            "pays_destination" => $this->pays_destination,
            "ville_destination" => $this->ville_destination,
            "prix_unitaire" => $this->prix_unitaire,
            "destination" => new DestinationCompagnieResource($this->destination)
        ];
    }
}
