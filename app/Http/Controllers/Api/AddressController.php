<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function __construct(Address $address)
    {
        $this->address = $address;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $address = $this->address->All();
       return  response()->json($address,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddressRequest $request)
    {
       $address = $this->address->create([
            'address'=>$request->address,
            'district' => $request->district,
            'cep' => $request->cep,
            'street' => $request->street,
            'number' => $request->number,
            'user_id' => $request->user_id 
       ]);

       return  response()->json($address,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $address = $this->address->find($id);
        if(!isset($address)){
            return response()->json(['erro' => 'Endereço pesquisado não existe'], 404) ;
        }
        return response()->json($address, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddressRequest $request, $id)
    {
        $address = $this->address->find($id); 
        if(!isset($address)){
            return response()->json(['erro' => 'Impossível realizar a atualização. O recurso solicitado não existe'], 404) ;
        }

        $address->address = $request->address;
        $address->district = $request->district;
        $address->cep = $request->cep;
        $address->street = $request->street;
        $address->number = $request->number;
        $address->user_id = $request->user_id;
        $address->save();

        return response()->json($address, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = $this->address->find($id);
        if(!isset($address)){
            return response()->json(['erro' => 'Rercurso pesquisado não existe'], 404) ;
        }
        $address->delete();
        return response()->json(['message' => 'O endereço foi removido com sucesso'], 200) ;

    }
}
