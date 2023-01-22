<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use \App\Models\SubmittedLoanRepayments;
use \App\Models\Loan;

class SubmittedLoanRepaymentsTest extends TestCase
{
    use RefreshDatabase;
    public function test_get_submitted_Loan_repayments_returns_a_successful_response()
    {
        $user = SubmittedLoanRepayments::create([
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response = $this->get('/api/submitted-loan-repayments');

        $response->assertStatus(201);
    }

    public function test_create_submitted_loan_repayments_api_returns_successful_response()
    {
        $this->post('/api/user-account',[
            "user_id" =>1,
            "amount" =>100,
        ]);

        $loan = Loan::create([
            "id" =>1,
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>true,
            "status" => "PENDING",
        ]);

        $this->post('/api/loan-repayment',[
            "amount" => 200,
            "loan_id" => $loan->id,
            "due_date" =>"2023-01-20",
            "status" => "PENDING",
        ]);

        $this->post('/api/loan-repayment',[
            "amount" => 200,
            "loan_id" => $loan->id,
            "due_date" =>"2023-01-27",
            "status" => "PENDING",
        ]);

        $response = $this->post('/api/submitted-loan-repayment',[
            "amount" => 200,
            "loan_id" => $loan->id,
        ]);

        $response->assertStatus(201);

    }

    public function test_get_submitted_loan_repayments_by_id()
    {
        $loan = SubmittedLoanRepayments::create([
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response= $this->get('/api/submitted-loan-repayment/'.$loan->id);

        $response->assertStatus(201);

    }

    public function test_put_submitted_loan_repayments_by_id()
    {
        $loan = SubmittedLoanRepayments::create([
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response = $this->put('/api/submitted-loan-repayment/'.$loan->id,[
            "id" =>1,
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response->assertStatus(201);

    }
}
