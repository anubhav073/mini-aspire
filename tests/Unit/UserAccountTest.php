<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\UserAccountController;
use \App\Models\UserAccount;

class UserAccountTest extends TestCase
{
    public function test_get_user_account_gives_correct_response()
    {
        $userAccount = new UserAccountController();
        $user = UserAccount::create([
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $userAccount->getUserAccount($user->id);
        $response = json_decode(json_encode($response))->original;
        $this->assertTrue($user->user_id == $response->user_id);
    }

    public function test_create_user_account_working()
    {
        $userAccount = new UserAccountController();
        $user = new \Illuminate\Http\Request([
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $userAccount->createUserAccount($user);

        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->user_id == 1);
    }

    public function test_put_user_account_working()
    {
        $userAccount = new UserAccountController();
        $user = new \Illuminate\Http\Request([
            "id" =>1,
            "user_id" =>1,
            "amount" =>100,
        ]);

        $response = $userAccount->createUserAccount($user);
        $response = json_decode(json_encode($response))->original;

        $user = new \Illuminate\Http\Request([
            "id" =>1,
            "user_id" =>1,
            "amount" =>1000,
        ]);

        $response = $userAccount->updateUserAccount($response->id,$user);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->amount == 1000);

    }

}
