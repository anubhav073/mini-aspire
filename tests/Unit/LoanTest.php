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

class LoanTest extends TestCase
{
    public function test_get_loan_gives_correct_response()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $loan = Loan::create([
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $loanController->getLoan($loan->id);
        $response = json_decode(json_encode($response))->original;
        $this->assertTrue($loan->user_id == $response->user_id);

    }

    public function test_create_loan_working()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $loan = new \Illuminate\Http\Request([
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $loanController->createLoan($loan);

        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->user_id == 1);
    }

    public function test_put_loan_working()
    {
        $loanController = new LoanController(new UserAccountController(),new LoanRepaymentsController());
        $loan = new \Illuminate\Http\Request([
            "amount" => 1000,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $loanController->createLoan($loan);
        $response = json_decode(json_encode($response))->original;

        $loan = new \Illuminate\Http\Request([
            "amount" => 100,
            "user_id" => 1,
            "loan_term" =>5,
            "is_approved"=>false,
            "status" => "PENDING",
        ]);

        $response = $loanController->updateLoan($response->id,$loan);
        $response = json_decode(json_encode($response))->original;

        $this->assertTrue($response->amount == 100);
    }

}
