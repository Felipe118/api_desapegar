<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserRepository
{
   public function __construct(User $user) 
   {
        $this->model = $user;
   }

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
}