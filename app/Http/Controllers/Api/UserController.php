<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Repository\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{ 
    public function __construct(UserRepository $user)
    {
        $this->repository = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return UserResource
     */
    public function index()
    {
        $user = $this->repository->findAll();

        return UserResource::collection($user); 
    } 

    /**
     * Register from users
     * 
     * @return UserResource
     */

    public function register(UserRequest $request) 
    {
        $user = $this->repository->register($request->all());

        return  new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserResource
     */
    public function update($id,Request $request)
    {
        $user = $this->repository->update($id, $request->all());

        return new UserResource($user);
    }

   
}
