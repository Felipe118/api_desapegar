<?php

namespace Tests\Feature\Api;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     *
     * @return void 
     */
    

    public function test_validations_fields_required_user()
    {
        
        $payload = [];

        $response = $this->postJson("/api/register",$payload);

        $response->assertJsonPath('errors.name.0', 'O campo name é obrigatório');
        $response->assertJsonPath('errors.password.0', 'O campo password é obrigatório');
        $response->assertJsonPath('errors.email.0', 'O campo email é obrigatório');
        // dd($response->json());

        
    }

    public function test_validation_if_email_is_format_right()
    {
        $payload = [
            'email' => 'sfsdfsdfsdf',
            'password' => 'fdfsdf',
            'name' => 'teste'
        ];

        $response = $this->postJson("/api/register",$payload);

        $response->assertJsonPath('errors.email.0', 'Digite um formato de e-mail válido');

        // dd($response->json());
    }

    public function test_register_new_user() 
    {
        $address = Address::factory()->create();

        $payload = [
            'name' => 'luis felipe',
            'email' => 'luis@email.com',
            'password' => '123456',
            'phone' => '61998252687',
            'address' => $address->id
        ];

        $response = $this->postJson('/api/register',$payload);

        $this->assertDatabaseHas('users', [
            'email' => 'luis@email.com'
        ]);

        $this->assertIsObject($response);
        
        $response->assertStatus(201);
    }

    public function test_update_if_user_not_authenticated()
    {
        $user = User::factory()->create();
        $response = $this->postJson("/api/updateUser/{$user->id}",[]);
        $response->assertStatus(401);


    }

   

    public function test_update_user_only_the_name()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'luis felipe test',
        ];
        
        $response = $this->postJson("/api/updateUser/{$user->id}",$payload, $this->defaultHeaders());
        // dd($response);
        $this->assertIsObject($response);

        $this->assertDatabaseHas('users', [
            'name' => 'luis felipe test'
        ]);


    }

    public function test_update_all_data_user()
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'luis felipe update',
            'email' => 'luis@teste.com',
            'password' => '654321',
            'phone' => '61998882928'
        ];

        $response = $this->postJson("/api/updateUser/{$user->id}",$payload, $this->defaultHeaders());
        
        $this->assertIsObject($response);

        $this->assertDatabaseHas('users', [
            'name' => 'luis felipe update'
        ]);
    }
}
