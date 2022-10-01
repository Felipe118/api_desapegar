<?php

namespace Tests\Feature\Api\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Feature\Api\UtilsTrait;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fail_authentication_if_email_or_password_is_wrong()
    {
       
        $response = $this->postJson('/api/login', []);
        $response->assertStatus(403);
        $response->assertJsonPath('erro','Usuário ou senha inválido!');
    }

    public function test_authentication_with_user_true()
    {
        $user = User::factory()->create();
        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'device_name' => 'test'
        ];
       
        $response = $this->postJson('/api/login', $payload);
        $token = $response->json();

        $response->assertStatus(200);
        $response->assertJsonPath('token', $token['token']);
        
    }

    public function test_logout_if_user_not_authenticated()
    {
        $response = $this->postJson('/api/logout',[]);
        $response->assertStatus(401);
    }

    public function test_logout()
    {
        $token = $this->createTokenUser();
        $response = $this->postJson('/api/logout',[],[
            'Authorization' => "Bearer {$token}"
        ]);
        $response->assertStatus(200);
    }

    public function test_success_get_me()
    {
        $token = $this->createTokenUser();
        $response = $this->getJson('/api/me',[
            'Authorization' => "Bearer {$token}"
        ]);
       
        $response->assertStatus(200);
    }
   
}
