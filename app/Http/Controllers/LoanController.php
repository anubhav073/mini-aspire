<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Loan;

class LoanController extends Controller
{
    protected $userAccountController;
    protected $loanRepaymentsController;

    public function __construct(UserAccountController $userAccountController,LoanRepaymentsController $loanRepaymentsController)
    {
        $this->userAccountController = $userAccountController;
        $this->loanRepaymentsController = $loanRepaymentsController;
    }

    public function createLoan(Request $request)
    {
        $validatedData = $request->validate([
            "amount" => "required",
            "user_id" => "required",
            "loan_term" => "required",
        ]);

        $validatedData["is_approved"] = false;
        $validatedData["status"]= "PENDING";

        $loan = Loan::create($validatedData);

        return response()->json($loan,201);
    }

    public function grantApproval($id)
    {
        $loan = Loan::find($id);
        $loan->is_approved = true;
        $loan = json_decode(json_encode($loan),FALSE);
        $loan2 = array();
        $loan2['id'] = $loan->id;
        $loan2['amount'] = $loan->amount;
        $loan2['user_id'] = $loan->user_id;
        $loan2['loan_term'] = $loan->loan_term;
        $loan2['status'] = $loan->status;
        $loan2['is_approved'] = true;
        $loan2 = new \Illuminate\Http\Request($loan2);
        $this->updateLoan($loan->id,$loan2);
        $userAccount = $this->userAccountController->getUserAccountByUserId($loan->user_id);
        $userAccount = json_decode(json_encode($userAccount),FALSE);
        $userAccount = $userAccount->original;
        $userAccount2['id'] = $userAccount->id;
        $userAccount2['user_id'] = $userAccount->user_id;
        $userAccount2['amount'] = $userAccount->amount + $loan->amount;
        $userAccount2 = new \Illuminate\Http\Request($userAccount2);
        $this->userAccountController->updateUserAccount($userAccount2['id'],$userAccount2);

        $day =7;
        for($i=0;$i<$loan->loan_term;$i++)
        {
            $loanRepayments=array();
            $loanRepayments["amount"] = $loan->amount/$loan->loan_term;
            $loanRepayments['loan_id'] = $loan->id;
            $loanRepayments['due_date'] = date('Y-m-d', strtotime('+'.$day.' days'));
            $loanRepayments = new \Illuminate\Http\Request($loanRepayments);
            $this->loanRepaymentsController->createLoanRepayment($loanRepayments);
            $day +=7;
        }

        return response()->json($loan,201);
    }

    public function getLoans()
    {
        $loans = Loan::all();
        return response()->json($loans,201);
    }

    public function getLoan($id)
    {
        $loan = Loan::find($id);
        return response()->json($loan,201);
    }

    public function updateLoan($id,Request $request)
    {
        $loan = Loan::find($id);
        $loan->user_id = $request['user_id'];
        $loan->amount = $request['amount'];
        $loan->loan_term = $request['loan_term'];
        $loan->save();

        return response()->json($loan,201);
    }

}
