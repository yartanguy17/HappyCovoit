<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Reservation extends JsonResource
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
            "date_reservation" => $this->date_reservation,
            "nbre_places" => $this->nbre_places - $this->nbre_places_annules,
            "prix_total" => $this->prix_total,
            "prix_total_commission" => $this->prix_total_commission,
            "status_reservation" => $this->status_reservation,
            "facture" => $this->facture,
            "status_siege" => $this->status_siege,
            "reference" => $this->reference,
            "destination" => ($this->type_destination==1)?$this->destination:$this->destinationCompagnie,
            "status" => $this->status,
            "timeout"=>($this->type_destination==1)?compareToCurrentTime($this->destination->date_demarrage . " " . $this->destination->heure):0,
            "status_paiement" => checkStatusReservation($this->id),
            "type_destination" => $this->type_destination,
            "is_signal" => $this->is_signal,
            "ligne_destination_id" => $this->ligne_destination_id,
            "ligne_destination" => ($this->ligne_destination_id==0)?"":getLigneById($this->ligne_destination_id),
            "note" => $this->note,
            "nbre_places_annules" => $this->nbre_places_annules,
            "date_depart" => $this->date_depart,
            "paiement" => ($this->type_destination==2)?$this->paiement:null,
            "sieges" => $this->sieges,
            "nom_infos" => ($this->type_destination==1)?getUserNameById($this->destination->user->id):"",
            "telephone_infos" => ($this->type_destination==1)?$this->destination->user->telephone:"",
            "avatar_infos" => ($this->type_destination==1)?$this->destination->user->avatar:"",
            "immatriculation_infos" => ($this->type_destination==1)?getVoyageurById($this->destination->user->id)->immatriculation:"",
            "type_vehicule_infos" => ($this->type_destination==1)?getVoyageurById($this->destination->user->id)->type_vehicule:""
        ];
    }
}
