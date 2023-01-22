<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Http\Controllers\LoanController;
use \App\Http\Controllers\LoanRepaymentsController;
use \App\Http\Controllers\UserAccountController;
use \App\Models\UserAccount;
use \App\Models\Loan;
use \App\Models\LoanRepayments;

class LoanRepaymentsTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_loan_repayments_gives_correct_response()
    {
        $loanRepaymentsController = new LoanRepaymentsController();
        $loanRepayments = LoanRepayments::create([
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $loanRepaymentsController->getLoanRepayment($loanRepayments->id);
        $response = json_decode(json_encode($response))->original;
        $this->assertTrue($loanRepayments->loan_id == $response->loan_id);

    }

    public function test_create_loan_repayments_working()
    {
        $loanRepaymentsController = new LoanRepaymentsController();
        $loan = new \Illuminate\Http\Request([
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $loanRepaymentsController->createLoanRepayment($loan);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->loan_id == 1);

    }

    public function test_put_loan_repayments_working()
    {
        $loanRepaymentsController = new LoanRepaymentsController();
        $loan = new \Illuminate\Http\Request([
            "amount" => 1000,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $loanRepaymentsController->createLoanRepayment($loan);
        $response = json_decode(json_encode($response))->original;

        $loan = new \Illuminate\Http\Request([
            "amount" => 100,
            "loan_id" => 1,
            "due_date" =>"2023-1-20",
            "status" => "PENDING",
        ]);

        $response = $loanRepaymentsController->updateLoanRepayment($response->id,$loan);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->amount == 100);

    }

}
