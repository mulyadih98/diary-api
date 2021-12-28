<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPost;
use App\Http\Requests\RegisterPost;
use App\Services\UserServices;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterPost $request, UserServices $userServices) {
        $user = $userServices->add($request->all());
        return response()->json([
            "message" => "user registration successful"
        ]);
    }

    public function login(LoginPost $request, UserServices $userServices) {
        $user = $userServices->getByEmail($request->email);
        if(!Hash::check($request->password,$user->password)){
            return response()->json([
                "message" => "wrong password"
            ],401);
        }
        $token = $user->createToken('secret_key')->plainTextToken;
        return response()->json([
            "name" => $user->name,
            "email" => $user->email,
            "isAdmin" => $user->isAdmin,
            "token" => $token 
        ]);
    }
}
