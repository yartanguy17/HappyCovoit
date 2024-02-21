<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\DestinationCompagnie as DestinationCompagnieResource;

class DestinationCompagnieCollection extends ResourceCollection{

    protected $date_demarrage;

     public function dateDemarrage($value){
        $this->date_demarrage = $value;
        return $this;
    }

    public function toArray($request){
        return $this->collection->map(function(DestinationCompagnieResource $resource) use($request){
            return $resource->dateDemarrage($this->date_demarrage)->toArray($request);
    })->all();

        // or use HigherOrderCollectionProxy
        // return $this->collection->each->foo($this->foo)->map->toArray($request)->all()

        // or simple
        // $this->collection->each->foo($this->foo);
        // return parent::toArray($request);
    }
}