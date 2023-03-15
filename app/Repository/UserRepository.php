<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
   public function __construct(
    protected User $model
   ){}

   /**
    * findAll users
    * @return array
    */

   public function findAll() :array
   {
       return $this->model->get()->toArray();
   }

   /**
    * register news users
    * @param array $data from users
    * @return array $user
    */

   public function register(array $data)
   {
        $user = $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
        ]);

        return $user;
   }

   /**
    * update register $user
    * @param int $id 
    * @param array $data 
    * @return $user
    */
   public function update($id,array $data)
   {
        $user = $this->model->findOrFail($id);

        $user->update($data);

        return $user;
   }
}