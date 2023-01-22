<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\LoanRepayments;

class LoanRepaymentsController extends Controller
{
    public function createLoanRepayment(Request $request)
    {
        $validatedData = $request->validate([
            "amount" => "required",
            "due_date" => "required",
            "loan_id" => "required",
        ]);

        $validatedData["status"]= "PENDING";

        $loanRepayments = LoanRepayments::create($validatedData);

        return response()->json($loanRepayments,201);
    }

    public function getLoanRepayments()
    {
        $loanRepayments = LoanRepayments::all();
        return response()->json($loanRepayments,201);
    }

    public function getFirstLoanRepaymentsByLoanId($loan_id)
    {
        $loanRepayments = LoanRepayments::where("loan_id",'=',$loan_id)->where("status",'=','PENDING')->firstOrFail();
        return response()->json($loanRepayments,201);
    }

    public function getLoanRepaymentsByLoanId($loan_id)
    {
        $loanRepayments = LoanRepayments::where("loan_id",'=',$loan_id)->where("status",'=','PENDING')->get();
        return response()->json($loanRepayments,201);
    }

    public function getLoanRepayment($id)
    {
        $loanRepayment = LoanRepayments::find($id);
        return response()->json($loanRepayment,201);

    }

    public function updateLoanRepayment($id,Request $request)
    {
        $loanRepayment = LoanRepayments::find($id);
        $loanRepayment->loan_id = $request['loan_id'];
        $loanRepayment->amount = $request['amount'];
        $loanRepayment->due_date = $request['due_date'];
        $loanRepayment->save();

        return response()->json($loanRepayment,201);
    }

    public function changeStatusToPaid($id)
    {
        $loanRepayment = LoanRepayments::find($id);
        $loanRepayment->status = "PAID";
        $loanRepayment->save();

        return response()->json($loanRepayment,201);
    }

}
