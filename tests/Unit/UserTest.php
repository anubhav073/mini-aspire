<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\UserAccountController;

class UserTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_user_gives_user_details()
    {
        $userController = new UserController(new UserAccountController());

        $user = User::create([
            "id" => 1,
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);

        $response = $userController->getUser($user->id);
        $response = json_decode(json_encode($response))->original;
        $this->assertTrue($user->email == $response->email);
    }

    public function test_create_user_working()
    {
        $userController = new UserController(new UserAccountController());
        $user = new \Illuminate\Http\Request([
            "id" => 1,
            "name"=>"test",
            "email" => "test@test.com",
            "phone" => "+91987654321",
            "password" => "123",
            "type" => "normal",
        ]);
        $response = $userController->index($user);

        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->email == 'test@test.com');
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
