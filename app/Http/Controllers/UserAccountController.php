<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\UserAccount;

class UserAccountController extends Controller
{
    public function createUserAccount(Request $request)
    {
        $validatedData = $request->validate([
            "user_id" => "required",
            "amount" => "required",
        ]);

        $userAccount = UserAccount::create($validatedData);

        return response()->json($userAccount,201);
    }

    public function getUserAccounts()
    {
        $userAccounts = UserAccount::all();
        return response()->json($userAccounts,201);
    }

    public function getUserAccount($id)
    {
        $userAccount = UserAccount::find($id);
        return response()->json($userAccount,201);

    }

    public function updateUserAccount($id,Request $request)
    {
        $userAccount = UserAccount::find($id);
        $userAccount->user_id = $request['user_id'];
        $userAccount->amount = $request['amount'];
        $userAccount->save();

        return response()->json($userAccount,201);
    }

    public function getUserAccountByUserId($user_id)
    {
        $userAccount = UserAccount::where('user_id', '=', $user_id)->firstOrFail();
        return response()->json($userAccount,201);
    }

}
