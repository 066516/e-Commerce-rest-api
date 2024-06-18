<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndex()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('api/users');
        $response->assertStatus(200);
    }

    public function testRegister()
    {
        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'isAdmin' => true,
        ];

        $response = $this->postJson('api/register', $data);
        $response->assertStatus(201)
                 ->assertJsonStructure(['user', 'token']);
    }

    public function testLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $data = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('api/login', $data);
        $response->assertStatus(200)
                 ->assertJsonStructure(['user', 'token']);
    }

    public function testShow()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')->get('api/users/' . $user->id);
        $response->assertStatus(200)
                 ->assertJson(['id' => $user->id]);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $data = ['name' => 'Updated Name'];

        $response = $this->actingAs($user, 'sanctum')
                         ->patchJson('api/users/' . $user->id, $data);
        $response->assertStatus(200)
                 ->assertJson(['name' => 'Updated Name']);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user, 'sanctum')
                         ->delete('api/users/' . $user->id);
        $response->assertStatus(204);
    }
}
