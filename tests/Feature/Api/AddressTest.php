<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_unauthenticated_create()
    {
        $response = $this->postJson('/api/address');

        $response->assertStatus(401);
    }

    public function test_authenticated_create()
    {
       
        //$user = User::factory()->create();
        // dd($user);
        // $payload = [
        //     'address' => 'Rua 5 casa 2 lote 5 ',
        //     'city' => 'Brasília',
        //     'district' => 'Teste',
        //     'street' => 'Rua 3',
        //     'number' => '23',
        //     'cep' => '7171717',
        //     'user_id' => $user->id
        // ];
       
        $response = $this->postJson('/api/address',[], $this->defaultHeaders());
        $response->assertStatus(422);
    }
}
