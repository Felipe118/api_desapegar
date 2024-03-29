<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    { 
        return [
            'id' => $this->id,
            'address' => $this->address,
            'city' => $this->city,
            'district' => $this->district,
            'cep' => $this->cep,
            'street' => $this->street,
            'number' => $this->number,
            'user' => new UserResource($this->user),
        ];
    }
}
