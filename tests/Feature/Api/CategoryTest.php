<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use UtilsTrait;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_category_with_user_unauthenticated() 
    {
        $response = $this->postJson('/api/categories',[]); 

        $response->assertStatus(401);
    }

    public function test_create_category_with_user_authenticated() 
    {
        $payload = [
            'name_category' => 'Category Test',
        ];
        $response = $this->postJson('/api/categories',$payload,$this->defaultHeaders()); 
        $response->assertStatus(201);
    }

    public function test_validations_category()
    {
        $payload = [
            'name_category' => '',
        ];
        $response = $this->postJson('/api/categories',$payload,$this->defaultHeaders()); 
        $response->assertStatus(422);
        $response->assertJsonPath('errors.name_category.0','O nome da categoria é obrigatório');
    }



    public function test_get_all_categories()
    {
        Category::factory()->count(10)->create();
        $response = $this->getJson('/api/categories',$this->defaultHeaders());
       
        $response->assertStatus(200);
    }


    public function test_update_category()
    {
        $category = Category::factory()->create();
        $payload = [
            'name_category' => 'Category Test Upload',
        ];
        $response = $this->putJson("/api/categories/{$category->id}",$payload,$this->defaultHeaders()); 
        $response->assertStatus(200);
    }

    public function test_delete_category()
    {
        $category = Category::factory()->create();
        $response = $this->deleteJson("/api/categories/{$category->id}",[],$this->defaultHeaders()); 
        $response->assertStatus(200);
    }
}
