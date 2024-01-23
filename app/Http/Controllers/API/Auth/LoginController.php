<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login (LoginRequest $request) {
    $loginRequest = $request->validated();

        if (Auth::attempt($loginRequest)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
         return   $this->successResponse(['user' => $user, 'token' => $token]);

        } else {
            return $this->errorResponse([], 'invalid credentials provided');
        }
    
}
}
