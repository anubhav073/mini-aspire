<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\Loan;

class LoanTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_Loans_returns_a_successful_response()
    {
        $user = Loan::create([
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $this->get('/api/loans');

        $response->assertStatus(201);
    }

    public function test_create_loan_api_returns_successful_response()
    {
        $response = $this->post('/api/loan',[
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response->assertStatus(201);

    }

    public function test_get_loan_by_id()
    {
        $loan = Loan::create([
            "id" =>1,
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response= $this->get('/api/loan/'.$loan->id);

        $response->assertStatus(201);

    }

    public function test_put_loan_by_id()
    {
        $loan = Loan::create([
            "id" => 1,
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $this->put('/api/loan/'.$loan->id,[
            "id"=>1,
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response->assertStatus(201);

    }

    public function test_grant_approval_api()
    {
        $loan = Loan::create([
            "id" => 1,
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $this->get('/api/grant-approval/'.$loan->id);

        $response->assertStatus(200);

    }

}
