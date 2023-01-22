<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\UserAccountController;
use \App\Http\Controllers\LoanController;
use \App\Http\Controllers\LoanRepaymentsController;
use \App\Http\Controllers\SubmittedLoanRepaymentsController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*oute::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/user',[UserController::class,'index']);
Route::get('/users',[UserController::class,'getUsers']);
Route::get('/user/{id}',[UserController::class,'getUser']);
Route::put('/user/{id}',[UserController::class,'updateUser']);
Route::post('/login',[UserController::class,'login']);

Route::post('/user-account',[UserAccountController::class,'createUserAccount']);
Route::get('/user-accounts',[UserAccountController::class,'getUserAccounts']);
Route::get('/user-account/{id}',[UserAccountController::class,'getUserAccount']);
Route::put('/user-account/{id}',[UserAccountController::class,'updateUserAccount']);
Route::get('/user-account-by-user-id/{user_id}',[UserAccountController::class,'getUserAccountByUserId']);

Route::post('/loan',[LoanController::class,'createLoan']);
Route::get('/grant-approval/{id}',[LoanController::class,'grantApproval'])->middleware('guard');
Route::get('/loans',[LoanController::class,'getLoans']);
Route::get('/loan/{id}',[LoanController::class,'getLoan']);
Route::put('/loan/{id}',[LoanController::class,'updateLoan']);

Route::post('/loan-repayment',[LoanRepaymentsController::class,'createLoanRepayment']);
Route::get('/loan-repayments',[LoanRepaymentsController::class,'getLoanRepayments']);
Route::get('/loan-repayment/{id}',[LoanRepaymentsController::class,'getLoanRepayment']);
Route::put('/loan-repayment/{id}',[LoanRepaymentsController::class,'updateLoanRepayment']);
Route::get('/first-loan-repayment-by-loan-id/{loan_id}',[LoanRepaymentsController::class,'getFirstLoanRepaymentsByLoanId']);
Route::get('/loan-repayment-by-loan-id/{loan_id}',[LoanRepaymentsController::class,'getLoanRepaymentsByLoanId']);


Route::post('/submitted-loan-repayment',[SubmittedLoanRepaymentsController::class,'createSubmittedLoanRepayment']);
Route::get('/submitted-loan-repayments',[SubmittedLoanRepaymentsController::class,'getSubmittedLoanRepayments']);
Route::get('/submitted-loan-repayment/{id}',[SubmittedLoanRepaymentsController::class,'getSubmittedLoanRepayment']);
Route::put('/submitted-loan-repayment/{id}',[SubmittedLoanRepaymentsController::class,'updateSubmittedLoanRepayment']);
