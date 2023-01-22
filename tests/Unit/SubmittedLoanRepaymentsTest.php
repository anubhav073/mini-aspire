<?php

namespace Tests\Unit;

use Tests\TestCase;
use \App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use \App\Http\Controllers\LoanController;
use \App\Http\Controllers\LoanRepaymentsController;
use \App\Http\Controllers\SubmittedLoanRepaymentsController;
use \App\Http\Controllers\UserAccountController;
use \App\Models\UserAccount;
use \App\Models\Loan;
use \App\Models\LoanRepayments;
use \App\Models\SubmittedLoanRepayments;

class SubmittedLoanRepaymentsTest extends TestCase
{
    public function test_get_submitted_loan_repayments_gives_correct_response()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $loanRepaymentsController = new SubmittedLoanRepaymentsController(new LoanRepaymentsController(),new UserAccountController(),$loanController);
        $loanRepayments = SubmittedLoanRepayments::create([
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response = $loanRepaymentsController->getSubmittedLoanRepayment($loanRepayments->id);
        $response = json_decode(json_encode($response))->original;
        $this->assertTrue($loanRepayments->loan_id == $response->loan_id);
    }


    public function test_create_submitted_loan_repayments_working()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $submittedLoanRepaymentsController = new SubmittedLoanRepaymentsController(new LoanRepaymentsController(),new UserAccountController(),$loanController);

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

        $submittedLoanRepayments = new \Illuminate\Http\Request([
            "amount" => 1000,
            "loan_id" => $loan->id,
            "status" => "PENDING",
        ]);

        $response = $submittedLoanRepaymentsController->createSubmittedLoanRepayment($submittedLoanRepayments);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->loan_id == $loan->id);
    }

    public function test_put_submitted_loan_repayments_working()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $submittedLoanRepaymentsController = new SubmittedLoanRepaymentsController(new LoanRepaymentsController(),new UserAccountController(),$loanController);

        $loanRepayments = SubmittedLoanRepayments::create([
            "amount" => 1000,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $submittedLoanRepayments = new \Illuminate\Http\Request([
            "amount" => 100,
            "loan_id" => 1,
            "status" => "PENDING",
        ]);

        $response = $submittedLoanRepaymentsController->updateSubmittedLoanRepayment($loanRepayments->id,$submittedLoanRepayments);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->amount == 100);

    }


}

