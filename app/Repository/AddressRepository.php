<?php

namespace App\Repository;

use App\Models\Address;

class AddressRepository
{
    public function __construct(Address $address)
    {
        $this->enity = $address;
    }

    public function getAllAddresses()
    {
        return  $this->enity->get();
    }

    public function store(array $data) :Address
    {
        $store = $this->enity->create([
            'address' => $data['address'],
            'city' => $data['city'],
            'district' => $data['district'],
            'cep' => $data['cep'],
            'street' => $data['street'],
            'number' => $data['number'],
            'user_id' => $data['user_id'],
        ]);

        return $store;
    }

    public function update(array $data, $id) :Address
    {
        $address = $this->enity->findOrFail($id);
        if($address == null){
         return response()->json(['message' => 'Endereço não encontrado'], 404);
        }
        $address->update($data);
        return $address;
    }

    public function delete($id)
    {
        $address = $this->enity->findOrFail($id);
        if($address === null){
            return response()->json(['erro' => 'Endereço pesquisado não existe'], 404) ;
        }
        $address->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso'], 200);
    }
}