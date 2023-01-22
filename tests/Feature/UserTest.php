<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    use RefreshDatabase;
    public function test_get_users_returns_a_successful_response()
    {
        $user = User::create([
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response = $this->get('/api/users');

        $response->assertStatus(201);
    }

    public function test_create_user_api_returns_successful_response()
    {
        $response = $this->post('/api/user',[
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response->assertStatus(201);

    }

    public function test_get_user_by_id()
    {
        $user = User::create([
            "id" => 1,
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response= $this->get('/api/user/'.$user->id);

        $response->assertStatus(201);

    }

    public function test_put_user_by_id()
    {
        $user = User::create([
            "id" => 1,
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response = $this->put('/api/user/'.$user->id,[
            "id" => 1,
            "name"=>"test",
            "email" => "test1@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response->assertStatus(201);

    }

    public function test_login()
    {
        $user = User::create([
            "id" => 1,
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response = $this->post('/api/login',[
            "email" => $user->email,
            "password" => $user->password,
        ]);

        $response->assertStatus(200);
    }

}
