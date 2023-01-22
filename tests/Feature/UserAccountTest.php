<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\UserAccount;

class UserAccountTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;
    public function test_get_user_accounts_returns_a_successful_response()
    {
        $user = UserAccount::create([
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $this->get('/api/user-accounts');

        $response->assertStatus(201);
    }

    public function test_create_user_account_api_returns_successful_response()
    {
        $response = $this->post('/api/user-account',[
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response->assertStatus(201);

    }

    public function test_get_user_account_by_id()
    {
        $userAccount = UserAccount::create([
            "id"=> 1,
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response= $this->get('/api/user-account/'.$userAccount->id);

        $response->assertStatus(201);

    }

    public function test_put_user_account_by_id()
    {
        $userAccount = UserAccount::create([
            "id"=>1,
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $this->put('/api/user-account/'.$userAccount->id,[
            "id" =>1,
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response->assertStatus(201);

    }

    public function test_get_user_account_by_user_id()
    {
        $userAccount = UserAccount::create([
            "id"=>1,
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $this->get('/api/user-account-by-user-id/'.$userAccount->user_id);

        $response->assertStatus(201);

    }

}
