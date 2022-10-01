<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Tests\TestCase;

trait UtilsTrait 
{
    public function createTokenUser($user = null)
    {
        $user =  User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test'
        ];
        $response = $this->postJson('/api/login', $payload);
        $token = $response->json();
        return $token['token'];
    }

    public function defaultHeaders()
    {
        $token = $this->createTokenUser();
        return [
            'Authorization' => "Bearer {$token}"
        ];
    }
}
