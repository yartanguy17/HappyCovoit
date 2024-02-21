<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            "pseudo" => $this->pseudo,
            "telephone" => $this->telephone,
            "password" => $this->password,
            "code_inscription" => $this->code_inscription,
            "token" => $this->token,
            "status" => $this->status,
            "avatar" => $this->avatar,
            "type_user" => $this->type_user,
            "nom" => getUserLastName($this->id),
            "prenoms" => getUserFirstName($this->id),
            "email" => getUserEmail($this->id),
            "immatriculation" => getUserImmatriculation($this->id),
            "type_vehicule" => getUserTypeVehicule($this->id),
            "infos" => getUserNameById($this->id)
        ];
    }
}
