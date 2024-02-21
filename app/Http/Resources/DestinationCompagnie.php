<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Reservation as ReservationResource;

class DestinationCompagnie extends JsonResource
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
            "nbre_places_dispo" => getPlacesDispoCompagnie($this->id),
            "prix_unitaire" => $this->prix_unitaire,
            "heure" => $this->heure,
            "pays_demarrage" => $this->pays_demarrage,
            "ville_demarrage" => $this->ville_demarrage,
            "jour" => $this->jour,
            "status" => $this->status,
            "user" => getUserNameById($this->user->id),
            "avatar" => $this->user->avatar,
            "reservations" => ReservationResource::collection($this->reservations),
            "reservations_clients" => $this->reservationsClient,
            "annulations" => $this->annulations,
            "lignes" => $this->lignes
        ];
    }
}
