<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use \App\Http\Controllers\UserAccountController;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $userAccountController;
    public function __construct(UserAccountController $userAccountController)
    {
        $this->userAccountController = $userAccountController;
    }

    public function index(Request $request)
    {
        $validatedData = $request->validate([
            "name" => "required",
            "email" => "required|email",
            "password" => "required",
            "phone" => "required",
            "type" => "required",
        ]);

        $user = User::create($validatedData);

        $userAccount["user_id"] = $user->id;
        $userAccount["amount"] = 0;

        $userAccount = new \Illuminate\Http\Request($userAccount);
        $this->userAccountController->createUserAccount($userAccount);

        return response()->json($user,201);

    }

    public function login(Request $request)
    {
        $validatedData = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);
        $user = User::where('email','=',$validatedData['email'])->where('password','=',$validatedData['password'])->firstOrFail();
        Session::put('type',$user->type);
        $request->session()->save();
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users,201);
    }

    public function getUser($id)
    {
        $user = User::find($id);
        return response()->json($user,201);

    }

    public function updateUser($id,Request $request)
    {
        $user = User::find($id);
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->type= $request['type'];
        $user->password = $request['password'];
        $user->save();

        return response()->json($user,201);
    }

}
