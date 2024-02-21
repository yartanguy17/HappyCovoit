<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DestinationNew extends JsonResource
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
            "nbre_places" => $this->nbre_places,
            "nbre_places_dispo" => getPlacesDispo($this->id),
            "prix_unitaire" => $this->prix_unitaire,
            "heure" => $this->heure,
            "is_confirmed" => $this->is_confirmed,
            "timeout"=>compareToCurrentTime($this->date_demarrage . " " . $this->heure),
            "pays_demarrage" => $this->pays_demarrage,
            "ville_demarrage" => $this->ville_demarrage,
            "date_demarrage" => $this->date_demarrage,
            "surcharge" => $this->surcharge,
            "status" => $this->status,
            "user" => getUserNameById($this->user->id),
            "verified" => getChauffeurStatusById($this->user->id),
            "avatar" => $this->user->avatar,
            "reservations" => $this->reservations
        ];
    }
}
