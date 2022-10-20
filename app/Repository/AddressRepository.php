<?php

namespace App\Repository;

use App\Models\Address;

class AddressRepository
{
    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    public function getAllAddresses()
    {
        return  $this->model->get();
    }

    public function getAddress($id)
    {
        $address = $this->model->findOrFail($id);

        return $address;
    }

    public function store(array $data)
    {
        $store = $this->model->create([
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
        $address = $this->model->findOrFail($id);
     
        $address->update($data);
        return $address;
    }

    public function delete($id)
    {
        $address = $this->model->findOrFail($id);
        
        $address->delete();
        return response()->json(['message' => 'Endereço deletado com sucesso'], 200);
    }
}