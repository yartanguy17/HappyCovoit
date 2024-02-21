<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Souscription extends JsonResource
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
            "validite" => $this->validite,
            "expiration" => $this->expiration,
            "date_souscription" => $this->date_souscription,
            "prix" => $this->prix,
            "facture" => $this->facture,
            "reference" => $this->reference,
            "type" => $this->type,
            "status_paiement" => checkStatusSouscription($this->id),
            "url_paygate" => ($this->paiements->count() > 0 && $this->paiements[0]->type == 1)?'https://paygateglobal.com/v1/page?token=8eb0b0e7-3cdb-44ac-a4ae-3ef66d8b01b4&amount=' . $this->paiements[0]['amount']  . '&description=Souscription&identifier='. $this->paiements[0]['identifier']:""
        ];
    }
}
