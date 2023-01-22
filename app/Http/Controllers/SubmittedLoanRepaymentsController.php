<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\SubmittedLoanRepayments;

class SubmittedLoanRepaymentsController extends Controller
{
    protected $loanRepaymentsController;
    protected $userAccountController;
    protected $loanController;
    public function __construct(LoanRepaymentsController $loanRepaymentsController,UserAccountController $userAccountController,LoanController $loanController)
    {
        $this->loanRepaymentsController = $loanRepaymentsController;
        $this->userAccountController = $userAccountController;
        $this->loanController = $loanController;
    }
    public function createSubmittedLoanRepayment(Request $request)
    {
        $validatedData = $request->validate([
            "amount" => "required",
            "loan_id" => "required",
        ]);

        $validatedData["status"]= "PAID";
        $loanRepayments = $this->loanRepaymentsController->getFirstLoanRepaymentsByLoanId($validatedData['loan_id']);
        $loanRepayments = json_decode(json_encode($loanRepayments))->original;

        if(!isset($loanRepayments) || ($loanRepayments->amount > $validatedData['amount']))
        {
            die("transaction not allowed with amount less than installment amount");
        }

        $this->loanRepaymentsController->changeStatusToPaid($loanRepayments->id);
        $remaining = $validatedData['amount'] - $loanRepayments->amount;
        $loan = $this->loanController->getLoan($validatedData['loan_id']);
        $loan = json_decode(json_encode($loan))->original;
        $userAccount = $this->userAccountController->getUserAccountByUserId($loan->user_id);
        $userAccount = json_decode(json_encode($userAccount))->original;
        $userAccount2['id'] = $userAccount->id;
        $userAccount2['user_id'] = $userAccount->user_id;
        $userAccount2['amount'] = $userAccount->amount + $remaining;
        $userAccount2 = new \Illuminate\Http\Request($userAccount2);
        $this->userAccountController->updateUserAccount($userAccount->id,$userAccount2);
        $loanRepayments2 = $this->loanRepaymentsController->getFirstLoanRepaymentsByLoanId($validatedData['loan_id']);
        if(!isset($loanRepayments2))
        {
            $loan->status = 'PAID';
            $loan->save();
        }

        $submittedLoanRepayments = SubmittedLoanRepayments::create($validatedData);

        return response()->json($submittedLoanRepayments,201);
    }

    public function getSubmittedLoanRepayments()
    {
        $submittedLoanRepayments = SubmittedLoanRepayments::all();
        return response()->json($submittedLoanRepayments,201);
    }

    public function getSubmittedLoanRepayment($id)
    {
        $submittedLoanRepayment = SubmittedLoanRepayments::find($id);
        return response()->json($submittedLoanRepayment,201);

    }

    public function updateSubmittedLoanRepayment($id,Request $request)
    {
        $submittedLoanRepayment = SubmittedLoanRepayments::find($id);
        $submittedLoanRepayment->loan_id = $request['loan_id'];
        $submittedLoanRepayment->amount = $request['amount'];
        $submittedLoanRepayment->save();

        return response()->json($submittedLoanRepayment,201);
    }
}
