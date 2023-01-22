<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\LoanRepayments;

class LoanRepaymentsTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_Loan_repayments_returns_a_successful_response()
    {
        $user = LoanRepayments::create([
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $this->get('/api/loan-repayments');

        $response->assertStatus(201);
    }

    public function test_create_loan_repayments_api_returns_successful_response()
    {
        $response = $this->post('/api/loan-repayment',[
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response->assertStatus(201);

    }

    public function test_get_loan_repayments_by_id()
    {
        $loan = LoanRepayments::create([
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response= $this->get('/api/loan-repayment/'.$loan->id);

        $response->assertStatus(201);

    }

    public function test_put_loan_repayments_by_id()
    {
        $loan = LoanRepayments::create([
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $this->put('/api/loan-repayment/'.$loan->id,[
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response->assertStatus(201);

    }

    public function test_get_loan_repayments_by_loan_id()
    {
        $loanRepayments = LoanRepayments::create([
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $this->get('/api/loan-repayment-by-loan-id/'.$loanRepayments->loan_id);

        $response->assertStatus(201);
    }

}
